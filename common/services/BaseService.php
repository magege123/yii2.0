<?php
namespace app\common\services;


class BaseService{

    protected static $_err_mag = null;
    protected static $_err_code = null;

    public static function _err($msg='',$code=-1){
        self::$_err_mag = $msg;
        self::$_err_code = $code;
        return false;
    }

    public static function getLastErrorMsg(){
        return self::$_err_mag;
    }

    public static function getLastErrorCode(){
        return self::$_err_code;
    }
}