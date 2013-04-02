<?php

/**
 * Skeleton subclass for performing query and update operations on the 'bot_session' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/31/13 23:31:19
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class botSessionPeer extends BasebotSessionPeer {

//  public static $BOT_SESSION_TIMEOUT = 60; // 60 сек

  public static $BOT_SESSION_TIMEOUT = 900; // 15 мин
//  public static $BOT_SESSION_TIMEOUT = 86400; // сутки (!!!!!! костыль !!!!!)

  /**
   * Получить ip адрес пользователя
   * @return string IP
   */

  public static function GetRealIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

  public static function generateAccessKey($botSessionId, $userId, $hardwareKey) {
    return md5(md5($botSessionId) . md5($userId) . md5($hardwareKey));
  }

  /**
   * Открыть сессию
   * @param type $userId id пользователя
   * @param type $hardwareKey уникальный ключ железа.А
   * @return botSession объект botSession
   */
  public static function openBotSession($userId, $hardwareKey) {

    $botSession = new botSession();
    $botSession->setUserId($userId);
    // IP адрес пользователя
    $botSession->setConnectIp(self::GetRealIp());
    // ключ железа
    $botSession->setHardwareKey($hardwareKey);
    $botSession->save();
    // ключ, который должен отправляться при каждом последующем запросе
    $botSession->setAccessKey(self::generateAccessKey($botSession->getId(), $userId, $hardwareKey));
    $botSession->save();
    return $botSession;
  }

  /**
   * Получить все открытые сессии
   * @param int $userId
   * @return botSession[] массив объектов сессий бота
   */
  public static function getActiveSessionsByUserId($userId) {

    $c = new Criteria();
    $c->add(self::USER_ID, $userId);
    $c->add(self::UPDATED_AT, date('Y-m-d H:i:s', time() - self::$BOT_SESSION_TIMEOUT), Criteria::GREATER_EQUAL);
    $c->add(self::IS_CLOSED, 0, criteria::EQUAL);

    return self::doSelect($c);
  }

  /**
   * Закрывает еще не закрытые, истекшие сессии
   * @param int $userId id пользователя
   * @return int $countClosedSessions количество завершенных сессий
   */
  public static function closeExpiredSessionsByUserId($userId) {

    $c = new Criteria();
    $c->add(self::USER_ID, $userId);
    $c->add(self::UPDATED_AT, date('Y-m-d H:i:s', time() - self::$BOT_SESSION_TIMEOUT), Criteria::LESS_THAN);
    $c->add(self::IS_CLOSED, 0, criteria::EQUAL);

    $botSessions = self::doSelect($c);

    foreach ($botSessions as $key => $botSession) {
      $botSession->setIsClosed(true);
      $botSession->save();
    }

    return count($botSessions);
  }

  /**
   * Проверка сессии
   * @param int $sessionId
   * @param string $accessKey
   * @return boolean true, если сессия существует и не просрочена
   */
  public static function checkSession($sessionId, $accessKey) {

    // если сессии не существует
    if (!$currentSession = self::retrieveByPK($sessionId)) {
      return false;
    }

    // закрываесм просроченные сессии
    self::closeExpiredSessionsByUserId($currentSession->getUserId());

    // если access_key совпадает
    if ($currentSession->getAccessKey() != $accessKey) {
      return false;
    }
    // если сессиия не закрыта
    if ($currentSession->getIsClosed()) {
      return false;
    }
    
    return true;
  }

}

// botSessionPeer
