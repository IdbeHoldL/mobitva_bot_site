<?php

/**
 * Skeleton subclass for performing query and update operations on the 'balance_operation' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 01/05/13 15:42:00
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class balanceOperationPeer extends BasebalanceOperationPeer {
  
  const BYE_LICENCE   = 1;
  const ADD_DAYS      = 2;
  const BYE_CONFIG    = 3;
  const ADD_CHARS     = 4;
  
    
  const PAYMENT       = 50;
  
  const ADMIN_BONUS   = 100;
  const SALE_CONFIG   = 101;


  public static $operationType = array(
    self::BYE_LICENCE   => 'покупка лицензии',
    self::ADD_DAYS      => 'продление лицензии',
    self::BYE_CONFIG    => 'покупка конфига',
    self::ADD_CHARS     => 'расширение лизензии (увеличение макс количества копий для запуска)',
    
    self::PAYMENT       => 'пополнение счета',
    
    self::ADMIN_BONUS   => 'бонус от администрации',
    self::SALE_CONFIG   => 'продажа конфига',
  );

  
  /**
   * Логирование операции со счетом.
   * @param int $userId - id пользователя
   * @param int $typeId - тип операции
   * @param int $operationData - обьект операции / номер транзакции
   */
  public static function addAction($userId, $typeId, $sum, $operationData, $additional) {
    
    $operation = new balanceOperation();
    $operation->setUserId($userId);
    $operation->setTypeId($typeId);
    $operation->setSum($sum);
    $operation->setOperationData($operationData);
    $operation->setAdditional($additional);

    return $operation->save();
  }

}

// balanceOperationPeer
