<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5 0005
 * Time: 下午 17:15
 */

namespace app\common\services\applog;


use app\common\services\UtilService;
use app\models\log\AppLog;

class AppLogServices
{
    public static function addErrorLog($appName,$content){
        $error = \Yii::$app->errorHandler->exception;
        $error_model = new AppLog();
        $error_model->app_name = $appName;
        $error_model->content = $content;
        $error_model->ip = UtilService::getIP();

        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $error_model->ua = $_SERVER['HTTP_USER_AGENT'];
        }

        if($error){
            $error_model->err_code = $error->getCode();
            if(isset($error->statusCode)){
                $error_model->http_code = $error->statusCode;
            }
            if(method_exists($error,'getName')){
                $error_model->err_name = $error->getName();
            }
        }

        $error_model->created_time = date("Y-m-d H:m:s");
        $error_model->save(0);
    }
}