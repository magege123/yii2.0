<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5 0005
 * Time: 下午 17:15
 */

namespace app\common\services\applog;


use app\common\services\UtilService;
use app\models\log\AppAccessLog;
use app\models\log\AppLog;

class AppLogServices
{
    //将错误日志写入数据库的方法
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

    //添加用户访问日志
    public static function addAppAccessLog($uid = 0){
        $get_params = \Yii::$app->request->get();
        $post_params = \Yii::$app->request->post();
        $referer_url = isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:'';
        $target_url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
        $ua = isset($_SERVER["HTTP_USER_AGENT"])?$_SERVER["HTTP_USER_AGENT"]:'';

        $model_access_log = new AppAccessLog();
        $model_access_log->uid = $uid;
        $model_access_log->referer_url = $referer_url;
        $model_access_log->target_url = $target_url;
        $model_access_log->ua = $ua;
        $model_access_log->query_params = json_encode(array_merge($get_params,$post_params));
        $model_access_log->ip = UtilService::getIP();
        $model_access_log->created_time = date("Y-m-d H:i:s");

        return $model_access_log->save(0);
    }
}