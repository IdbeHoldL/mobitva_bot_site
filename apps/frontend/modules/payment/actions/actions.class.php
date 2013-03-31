<?php

/**
 * payment actions.
 *
 * @package    mobitvabot
 * @subpackage payment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class paymentActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        
    }

    public function executeConfirm(sfWebRequest $request) {

        if ($this->getUser()->isAnonymous()) {
            $this->redirect('index/index');
        }

        $this->price = 45;
        $this->month = 1;
        $this->userId = $this->getUser()->getProfile()->getId();
        $this->userName = $this->getUser()->getUserName();
        $this->transactionKey = sha1(microtime());
        if ($month = $request->getPostParameter('month')) {


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
                $price += 45 * $k;
            }

            $this->price = $price;
            $this->month = $month;
            
            $transaction = new mobitvabotTransaction();
            $transaction->setPrice($this->price);
            $transaction->setUserId($this->userId);
            $transaction->setMd5hash($this->transactionKey);
            $transaction->save();
            
        }
    }

    
    public function executeW1log() {

        function print_answer($result, $description) {
            print "WMI_RESULT=" . strtoupper($result) . "&";
            print "WMI_DESCRIPTION=" . urlencode($description);
            exit();
        }

        $skey = "SXw0bndoVXhITEZGUklBdDR0QjFIckR6e2BL";

        // Функция, которая возвращает результат в Единую кассу
        // Проверка наличия необходимых параметров в POST-запросе

        if (!isset($_POST["WMI_SIGNATURE"]))
            print_answer("Retry", "Отсутствует параметр WMI_SIGNATURE");

        if (!isset($_POST["WMI_PAYMENT_NO"]))
            print_answer("Retry", "Отсутствует параметр WMI_PAYMENT_NO");

        if (!isset($_POST["WMI_ORDER_STATE"]))
            print_answer("Retry", "Отсутствует параметр WMI_ORDER_STATE");

        // Извлечение всех параметров POST-запроса, кроме WMI_SIGNATURE
        foreach ($_POST as $name => $value) {
            if ($name !== "WMI_SIGNATURE")
                $params[$name] = $value;
        }

        // Сортировка массива по именам ключей в порядке возрастания
        // и формирование сообщения, путем объединения значений формы

        uksort($params, "strcasecmp");
        $values = "";

        foreach ($params as $name => $value) {
            $values .= $params[$name];
        }

        // Формирование подписи для сравнения ее с параметром WMI_SIGNATURE
        $signature = base64_encode(pack("H*", md5($values . $skey)));

        //Сравнение полученной подписи с подписью W1
        if ($signature == $_POST["WMI_SIGNATURE"]) {
            if (strtoupper($_POST["WMI_ORDER_STATE"]) == "ACCEPTED") {
                // TODO: Пометить заказ, как «Оплаченный» в системе учета магазина
                
                $details = '';
                foreach ($params as $name => $value) {
                    $details .= $name.' = '.$value . PHP_EOL;
                }
                
                $criteria = new Criteria();
                $criteria->add(mobitvabotTransactionPeer::MD5HASH, $_POST["transactionKey"]);
                $transacrion = mobitvabotTransactionPeer::doselectOne($criteria);
                $transacrion->setIsConfirmed(true);
                $transacrion->setDetails($details);
                $transacrion->save();
                
                $criteria = new Criteria();
                $criteria->add(sfGuardUserProfilePeer::ID, $_POST["user_id"]);
                $CurrentTransactionUser = sfGuardUserProfilePeer::retrieveByPK($_POST["user_id"]);
                $CurrentTransactionUser->setTransactionId($transacrion->getId());
                // дата окончания лицензии
                $CurrentTransactionUser->setLicenseEndDate(date("d.m.Y",time() + 24 * 60 * 60 * 30 * $_POST["month_count"]));
                $CurrentTransactionUser->setIsByer(true);
                $CurrentTransactionUser->save();
                
                print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] . " оплачен!");
            } else {
                // Случилось что-то странное, пришло неизвестное состояние заказа
                print_answer("Retry", "Неверное состояние " . $_POST["WMI_ORDER_STATE"]);
            }
        } else {
            // Подпись не совпадает, возможно вы поменяли настройки интернет-магазина
            print_answer("Retry", "Неверная подпись " . $_POST["WMI_SIGNATURE"]);
        }
        
        return sfView::NONE;
    }
    
    public function executePaymentOk(){
    }
    
    public function executePaymentFail(){
    }
}
