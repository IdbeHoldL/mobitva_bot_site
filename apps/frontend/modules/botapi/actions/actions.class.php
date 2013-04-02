<?php

/**
 * botapi actions.
 *
 * @package    mobitva
 * @subpackage botapi
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class botapiActions extends sfActions {

  protected $ERROR_NO_USER = 'Не найден пользователь';
  protected $ERROR_USER_NO_ACTIVE = 'Пользователь неактивен/заблокирован';
  protected $ERROR_WRONG_USER_AUTH_KEY = 'Неверный ключ';
  protected $ERROR_ERROR_OPEN_SESSION = 'Ошибка авторизации (невозможно открыть сессию)';
  protected $ERROR_NO_LICENSE = 'Нет лицензии';
  protected $ERROR_LICENSE_NO_ACTIVE = 'Лицензия неактивна';
  protected $ERROR_WRONG_OR_EXPIRED_SESSION = 'Время жизни сессии истекло';
  protected $ERROR_BAD_VERSION = 'Ваша версия бота устарела и отключена. Новая версия бота доступна для скачивания на сайте (http://mobitva-bot.ru)';
  
  
  protected $BOT_VERSION = '1.1';
  /**
   * Возврашает параметр в кодировке utf-8 (ожидается windows-1251)
   * @param sfWebRequest $request запрос
   * @param string $name имя параметра
   * @return string пришедший парамерт, иначе false
   */
  protected function getUrlParam($request, $name) {

    if (!$request->getParameter($name)) {
      return false;
    }

    return iconv('windows-1251', 'utf-8', $request->getParameter($name));
  }

  /**
   * Тестовое действие
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {

    $params = $request->getParameter('testparam');
    var_dump($params);
    die();
    $param2 = $request->getParameter('testparam_2');
    $param3 = iconv('windows-1251', 'utf-8', $request->getParameter('testparam_3'));

    $responce = $param1 . ' ' . $param2 . ' ' . $param3 . ' I work! русский текст!!!!!!!!!';

    header('Content-Type: text/html; charset=utf-8');

    echo $responce;
    return sfView::NONE;
  }

  /**
   * Выполнить метод апи. 
   * Обновление данных сессии, обработка запроса, 
   * @param sfWebRequest $request 
   */
  public function executeRunMethod(sfWebRequest $request) {

    // получаем имя метода
    $methodName = $request['method_name'];
    // получаем id сессии и access_key (ключ сессии)
    $sessionId = $request['session_id'];
    $accessKey = $request['access_key'];

    if (!botSessionPeer::checkSession($sessionId, $accessKey)) {
      echo $this->ERROR_WRONG_OR_EXPIRED_SESSION;
      return sfView::NONE;
    }
    // получение параметров
    if (($params = $request->getParameter('params')) && is_array($params)) {
      foreach ($params as $key => $param) {
        $params[$key] = iconv('windows-1251', 'utf-8', $param);
      }
    } else {
      $params = array();
    }

    $botSession = botSessionPeer::retrieveByPK($sessionId);
    $user = sfGuardUserPeer::retrieveByPK($botSession->getUserId());
    $license = licensePeer::getUserLicense($user);

    if (!$botSession || !$user || $license) {
      echo $this->ERROR_WRONG_OR_EXPIRED_SESSION;
      return sfView::NONE;
    }

    $botApi = new botApi($botSession, $user, $license);

    if (method_exists($botApi, $methodName)) {
      $response = $botApi->$methodName($params);
      if (!$response) {
        echo 'EMPTY_RESPONSE';
      } else {
        echo $response;
      }
    } else {
      echo 'METHOD_NOT_FOUND';
    }
    return sfView::NONE;
  }

  /**
   * авторизация пользователя
   * @param sfWebRequest $request
   * @return type 
   */
  public function executeSignin(sfWebRequest $request) {

//    url:   /botapi/signin/:username/:access_key/:hardware_key
    $username = $this->getUrlParam($request, 'username'); // username
    $authKey = $this->getUrlParam($request, 'access_key');
    $hardwareKey = $this->getUrlParam($request, 'hardware_key');
    $bot_version = $this->getUrlParam($request, 'bot_version');

    if ($bot_version < str_replace('.', '', $this->BOT_VERSION)){
      echo $this->ERROR_BAD_VERSION;
      return sfView::NONE;
    }

    // если пользователя не существует
    if (!$user = sfGuardUserPeer::retrieveByPk($username)) {
      echo $this->ERROR_NO_USER;
      return sfView::NONE;
    }

    $username = $user->getUsername();

    // если пользователь не активен
    if (!$user->getIsActive()) {
      echo $this->ERROR_USER_NO_ACTIVE;
      return sfView::NONE;
    }
    // если access_key неверен
    if ($user->getProfile()->getAuthKey() != $authKey) {
      echo $this->ERROR_WRONG_USER_AUTH_KEY;
      return sfView::NONE;
    }
    // проверяем наличие лицензии
    if (!$license = licensePeer::getUserLicense($user->getProfile()->getId())) {
      echo $this->ERROR_NO_LICENSE;
      return sfView::NONE;
    }
    // проверяем активна ли лицензия
    if (!$license->isActive()) {
      echo $this->ERROR_LICENSE_NO_ACTIVE;
      return sfView::NONE;
    }

    // закрываем все просроченные сессии
    botSessionPeer::closeExpiredSessionsByUserId($user->getProfile()->getId());

    // получаем все открытые сессии.
    if ($activeSessions = botSessionPeer::getActiveSessionsByUserId($user->getProfile()->getId())) {
      $lastDate = $activeSessions[0]->getCreatedAt();
      $lastDateKey = 0;
      // перебираем их, проверяем hardwarekey, заодно 
      foreach ($activeSessions as $key => $activeSession) {
        if ($activeSession->getHardwareKey() != $hardwareKey) {
          // закрываем сессии в отличными от текущего hardware-ключами
          $activeSession->setIsClosed(true);
          $activeSession->save();
          // удаляем ис списка закрытые сессии
          unset($activeSessions[$key]);
        } elseif (true) { // если ключ совпадает, то  проверим дату открытия сессии
          if ($lastDate > $activeSession->getCreatedAt()) {
            // запоминаем самую старую сессию, это пригодится позже, когда проверим ограничение на количество запусков
            $lastDate = $activeSession->getCreatedAt();
            $lastDateKey = $key;
          }
        }
      }
      // если
      $countActiveSessions = count($activeSessions);
      $countActiveSessionsLimit = licenseCharsPlacesPeer::getCountCharsByLicenseId($license->getId());
      // если количество активных сессий больше, чем макс допустимо
      if ($countActiveSessions && $countActiveSessions >= $countActiveSessionsLimit) {
        // закрываем самую старую сессию

        $activeSessions[$lastDateKey]->setIsClosed(true);
        $activeSessions[$lastDateKey]->save();
        unset($activeSessions[$lastDateKey]);
      }
    }

    // пытаемся открыть сессию
    if (!$botSession = botSessionPeer::openBotSession($user->getProfile()->getId(), $hardwareKey)) {
      echo $this->ERROR_OPEN_SESSION;
      return sfView::NONE;
    }

    $response =
            $botSession->getId() . '-' .
            $botSession->getAccessKey() . '-' .
            $user->getProfile()->getId() . '-' .
            $license->getId();

    echo $response;
    return sfView::NONE;
  }
  
  public function executeAddSessionTime(sfWebRequest $request) {
    
    $session_id = $this->getUrlParam($request, 'session_id');
    $hardwareKey = $this->getUrlParam($request, 'hardware_key');
    
    if (!$botSession = botSessionPeer::retrieveByPK($session_id)){
      echo 'no session';
      return sfView::NONE;
    }
    
    if ($botSession->getIsClosed()){
      echo 'ession is closed';
      return sfView::NONE;
    }
    
    if ($botSession->getHardwareKey() != $hardwareKey){
      echo 'wrong key';
      return sfView::NONE;
    }
    
    if ($botSession->getUpdatedAt() < date('Y-m-d h:i:s', time() - botSessionPeer::$BOT_SESSION_TIMEOUT) ){
      $botSession->setIsClosed(true);
      $botSession->save();
      echo 'expired time';
      return sfView::NONE;
    }
    
    $botSession->setUpdatedAt(date('Y-m-d h:i:s', time()));
    $botSession->save();
            
    echo 1;
    return sfView::NONE;
  }
  

}
