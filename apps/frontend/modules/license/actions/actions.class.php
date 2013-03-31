<?php

/**
 * license actions.
 *
 * @package    mobitva
 * @subpackage license
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class licenseActions extends sfActions {

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeIndex(sfWebRequest $request) {

    if ($this->getUser()->isAnonymous()) {
      $this->redirect('index/index');
    }

    $this->license = licensePeer::getUserLicense($this->getUser()->getGuardUser()->getId());
  }

  /**
   * Продление лицензии
   * @param sfWebRequest $request 
   */
  public function executeAddDays(sfWebRequest $request) {

    if ($this->getUser()->isAnonymous()) {
      $this->redirect('index/index');
    }

    $this->userId = $this->getUser()->getProfile()->getId();
    $this->userBalance = $this->getUser()->getProfile()->getBalance();
    $this->license = licensePeer::getUserLicense($this->userId);
    $this->preEnd = ($this->license && strtotime($this->license->getDateEnd()) > time()) ? true : false;

    // высчитываем стоимость бота, исходя из количества месяцев, на которое покупается программа

    if ($request->isMethod(sfRequest::POST)) {

      if ($month = $request->getParameter('month')) {

        if ($month < 0) {
          $month = 1;
        }

        $price = 0;
        $persents = 1;
        $koef_persents = 0;

        for ($i = 0; $i < $month; $i++) {
          $k = (1 - 0.05 * $i);
          if ($k < 0.3) {
            $k = 0.3;
          }
          $price += sfConfig::get('app_bot_price') * $k;
        }
        // $price - стоимость продления бота на заданный период.
        // создаем/получаем текущую лицензию
        if (!$license = licensePeer::getUserLicense($this->userId)) {
          $this->isNew = true;
          $license = new license();
          $license->setUserId($this->userId);
          $license->setCharsCount(1);
        }

        $unspentSeconds = 0; //количество неизрасходованных дней (в секундах)
        // если лицензия еще не истекла, добавляем скидку, 
        if (strtotime($license->getDateEnd()) > time()) {
          // запоминаем количество неизрасходованных дней
          $unspentSeconds = strtotime($license->getDateEnd()) - time();
          // вычитаем скидку за своевременное продление
          $price = $price * (100 - (int) sfConfig::get('app_bot_pre_end_discount')) / 100;
        }


        // высчитываем новую дату окончания лицензии
        $secondsToAdd = 86400 * 30 * $month + $unspentSeconds;
        // задаем новую дату окончания лицензии
        $license->setDateEnd(date('Y-m-d', time() + $secondsToAdd));

        // проверяем, что у пользователя достаточно средств для оплаты.
        if ($this->userBalance < $price) {
          $this->result = false;
          $this->message = sfConfig::get('app_bot_messages_need_more_money');
          return;
        }

        // списываем средства
        $this->getUser()->getProfile()->setBalance($this->userBalance - $price)->save();

        // добавляем запись о списаниии в лог действий со счетом.
        $operationTypeId = ($this->isNew) ? balanceOperationPeer::BYE_LICENCE : balanceOperationPeer::ADD_DAYS;
        $additional = (($this->isNew) ? "Покупка" : "Продление") . " лицензии на " . $month . ' мес.';
        balanceOperationPeer::addAction($this->userId, $operationTypeId, $price, $license->getId(), $additional);

        // сохраняем изменения / создаем обьект
        $license->save();
      }
    }
  }

  /**
   * Добавление мест для персонажей
   * @param sfWebRequest $request 
   */
  public function executeAddChars(sfWebRequest $request) {

    if ($this->getUser()->isAnonymous()) {
      $this->redirect('index/index');
    }

    $this->userId = $this->getUser()->getProfile()->getId();
    $this->userBalance = $this->getUser()->getProfile()->getBalance();
    $this->license = licensePeer::getUserLicense($this->userId);

    if (!$this->license) {
      $this->redirect('index/index');
    }


    if ($request->isMethod(sfRequest::POST)) {

      $charsCount = (int) $request->getParameter('chars_count');
      $monthCount = (int) $request->getParameter('month_count');

      $charsCount = ($charsCount > 0) ? $charsCount : 1;
      $monthCount = ($monthCount > 0) ? $monthCount : 1;

      $charPrice = sfConfig::get('app_bot_add_char_price');
      $monthPrice = sfConfig::get('app_bot_add_char_mounts_price');

      $price = 0;

      $price += $this->getPrice($charPrice, $charsCount);
      $price += $charsCount * $this->getPrice($monthPrice, $monthCount);

      $bonusForCountChars = $charsCount * 0.01;
      $bonusForCountMonth = $monthCount * 0.01;

      $bonusForCountChars = ($bonusForCountChars < 0.17) ? $bonusForCountChars : 0.17;
      $bonusForCountMonth = ($bonusForCountMonth < 0.17) ? $bonusForCountMonth : 0.17;

      $price = $price * (1 - ($bonusForCountChars + $bonusForCountMonth));

      // проверяем, что у пользователя достаточно средств для оплаты.
      if ($this->userBalance < $price) {
        $this->result = false;
        $this->message = sfConfig::get('app_bot_messages_need_more_money');
        return;
      }

      // списываем средства
      $this->getUser()->getProfile()->setBalance($this->userBalance - $price)->save();

      // добавляем запись о списаниии в лог действий со счетом.
      $operationTypeId = balanceOperationPeer::ADD_CHARS;
      $additional = "Добавление мест для персонажей: (+" . $charsCount . ' мест, на '. $monthCount .' мес.)';
      balanceOperationPeer::addAction($this->userId, $operationTypeId, $price, $this->license->getId(), $additional);

      // сохраняем изменения, добавляем запись в БД
      $licenseCharsPlaces = new licenseCharsPlaces();
      $licenseCharsPlaces->setLicenseId($this->license->getId());
      $licenseCharsPlaces->setCharsCount($charsCount);
      $licenseCharsPlaces->setDateEnd(date('Y-m-d', time() + 60*60*24*30*$monthCount));
      $licenseCharsPlaces->save();
      
    }
  }

  public function executeConfirmLicense(sfWebRequest $request) {

    if ($this->getUser()->isAnonymous()) {
      $this->redirect('index/index');
    }
  }

  protected function getPrice($price, $count) {

    $resultPrice = 0;
    $persents = 1;

    for ($i = 0; $i < $count; $i++) {

      $k = (1 - 0.05 * $i);
      if ($k < 0.3) {
        $k = 0.3;
      }
      $resultPrice += $price * $k;
    }

    return $resultPrice;
  }

}
