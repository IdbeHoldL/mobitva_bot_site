<?php

class api {

    // загружается из yaml файла
    public static $methods = array();
    protected static $response;
    // response code
    public static $success_code = '200';
    public static $error_method_not_allowed = array('405', 'Method Not Allowed');
    // для api
    public static $error_unknown_param          = array('600', 'Unknown Param');
    public static $error_wrong_param_type       = array('601', 'Wrong Param Type');
    public static $error_not_enough_parameters  = array('602', 'Not Enough Parameters');
    
    public static $error_007 = array('007', 'James Bond error =( ');

    public static function configure() {

        self::$methods = sfYAML::Load('../lib/inight/api/api_methods.yml');

        self::$response = array(
            'code' => self::$success_code,
            'response' => array(),
            'error_message' => array()
        );
    }

    protected static function addExeption($static_error, $info) {
        
        throw new sfException($static_error[1] . $info, $static_error[0]);
    }
    
    protected static function checkType($type, $param) {

        switch ($type) {
            case 'array':
                if (!is_array($param)) {
                    return false;
                }
                break;
            case 'string':
                if (!is_string($param)) {
                    return false;
                }
                break;
            case 'int':
                if (!is_integer($param)) {
                    return false;
                }
                break;
        }

        return true;
    }
    
    public static function run($methodName, $params) {

        self::configure();

//        var_dump(self::$methods);
//        var_dump($methodName);
//        var_dump($params);
        
        try {

            if (!array_key_exists($methodName, self::$methods['methods'])) {
                self::addExeption(self::$error_method_not_allowed);
            }
            
//            var_dump(self::$methods['methods'][$methodName]);
            
            // проверка параметров
            foreach ($params as $key => $param) {
                if (!array_key_exists($key, self::$methods['methods'][$methodName]['params'])) {
                    self::addExeption(self::$error_unknown_param, " : $key" );
                }
                $param_type = self::$methods['methods'][$methodName]['params'][$key]['type'];
                if (!self::checkType($param_type,$param)) {
                    self::addExeption(self::$error_wrong_param_type, " : $key.  Was expected :  $param_type");
                }
            }

            foreach (self::$methods['methods'][$methodName]['params'] as $key => $param){
                if (!array_key_exists($key, $params) && self::$methods['methods'][$methodName]['params'][$key]['required']){
                    self::addExeption(self::$error_not_enough_parameters, ". $key : required");
                }
            }
            
            
            // вызываем метод
            self::$response['response'] = methods::$methodName($params);
            
        } catch (Exception $e) {
//            echo "I'm exeptoin and I know it!";
            self::$response['code'] = $e->getCode();
            self::$response['error_message'] = $e->getMessage();
        }

        // TODO:
        // 
        // проверку на существование метода
        // проверку на типы переменных
        // запуск метода
        // ???
        // PROFIT!!!
//        return array('code');

        return json_encode(self::$response);
    }
    
    

}