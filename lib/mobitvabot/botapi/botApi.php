<?php

function parse_botconfig($str, $ProcessSections=true) {
  $lines = explode("\n", $str);
  $return = Array();
  $inSect = false;
  foreach ($lines as $line) {
    $line = trim($line);
    if (!$line || $line[0] == "#" || $line[0] == ";")
      continue;
    if ($line[0] == "[" && $endIdx = strpos($line, "]")) {
      $inSect = substr($line, 1, $endIdx - 1);
      continue;
    }
    if (!strpos($line, '=')) // (We don't use "=== false" because value 0 is not valid as well)
      continue;

    $tmp = explode("=", $line, 2);

    $commandKey = trim($tmp[0]);
    if (isset($return[$inSect])) {
      $commandKey = getUnicalKey(trim($tmp[0]), $return[$inSect]);
    }
    
    $value = ltrim($tmp[1]);
    if (trim($tmp[0]) == 'expression' || trim($tmp[0]) == 'command') {
      $value = str_replace(' ', '', $value);
      $value = str_replace('AND', ' AND ', $value);
      $value = str_replace('OR', ' OR ', $value);
      $value = str_replace('NOT', ' NOT ', $value);
    }
    
    $return[$inSect][$commandKey] = $value;

  }
  return $return;
}

function getUnicalKey($key, $array) {
  for ($i = 0; $i <= 10000; $i++) {
    // если нет такого ключа - вохвращаем
    $returnKey = $key . '_' . $i;
    if (!array_key_exists($returnKey, $array)) {
      return $returnKey;
    }
  }
  return $key;
}

function ini_to_string($iniArray) {
  $result = '';
  foreach ($iniArray as $sname => $section) {
    $result .= '[' . $sname . ']' . "\r\n";
    foreach ($section as $key => $value) {
      $result .= $key . '=' . $value . "\r\n";
    }
    $result .= "\r\n";
  }

  return $result;
}

/**
 * Тут описаны все апи-методы бота.
 * Если метод возвращает false это значит, что ответ не может быть получен
 * и клиенту вернется ошибка
 * @author q
 */
class botApi {

  public $botSession = null;
  public $user = null;
  public $license = null;
  public $separator = '-<botapi_separator>-';
  public $separator2 = '-<botapi_separator_2>-';
  public $separator3 = '-<botapi_separator_3>-';

  public function __construct($botSession, $user, $license) {
    $this->botSession = $botSession;
    $this->user = $user;
    $this->license = $license;
  }

  /**
   * Тест Апи. 
   * @param array $params
   * @return string "ок!"
   */
  public function testApi($params) {
    return 'ok!';
  }

  /**
   * Возвращает список конфигов
   */
  public function getUserConfigs($params) {
    $configs = botconfigPeer::getUserConfigs($this->user->getId());
    $responseArray = array();
    foreach ($configs as $config) {
      $responseArray[] = $config->getId() . $this->separator2 . $config->getName();
    }
    
    $configs = botconfigPeer::getGlobalConfigs();
    
    foreach ($configs as $config) {
      $responseArray[] = $config->getId() . $this->separator2 . $config->getName();
    }

    return implode($this->separator, $responseArray);
  }

  /**
   * Возвращает текст конфига
   * @param array $params 
   */
  public function getConfig($params) {
    $engine = parse_botconfig(file_get_contents('bot_engine.ini', 1), true);

    // прверяем пришел ли id конфига
    if (!isset($params['config_id'])) {
      return false;
    }
    $configId = $params['config_id'];
    
    // получаем конфиг
    if (!$config = botconfigPeer::retrieveByPK($configId)) {
      return false;
    }
    // проверяем, имеет ли пользователь доступ к этому конфигу
    if ($config->getUserId() != $this->user->getId()) {
      if (!botconfigPeer::checkUserConfigAccess($this->user->getId(), $config->getId())) {
        return false;
      }
    }
    // секции связанных конфигов
    $relationConfigsSections = botconfigRelationsPeer::getIniWithRelations($config, array());
    // секции связанных конфигов имеют больший приоритет, чем секции движка
    $resultSections = array_merge($engine, $relationConfigsSections);
    // секции подключаемого конфига имеют больший приоритет, чем все остальные
    $resultSections = array_merge($resultSections, parse_botconfig($config->getBody(), true));
    
    return ini_to_string($resultSections);
  }
  
  public function addSessionTime($params){
    
    $this->botSession->setUpdatedAt(time());
    $this->botSession->sate();
    
  }

}

?>
