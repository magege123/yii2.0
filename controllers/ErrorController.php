<?php

namespace app\controllers;

use app\common\services\applog\AppLogServices;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\log\FileTarget;
use app\common\components\BaseWebController;


class ErrorController extends BaseWebController
{
    //public $layout = true;
    public function actionError(){
        $error = \Yii::$app->errorHandler->exception;
        $err_msg = '';
        if($error){
            $file = $error->getFile();
            $line = $error->getLine();
            $message = $error->getMessage();
            $code = $error->getCode();
            $err_msg = $message."&nbsp;[file:{$file}][line:{$line}][code:{$code}][url:{$_SERVER[REQUEST_URI]}][POST_DATA:".http_build_query($_POST)."]";
            $log = new FileTarget();
            $log->logFile = \Yii::$app->getRuntimePath()."/logs/err.log";
            $log->messages[] = [
                $err_msg,
                1,
                'application',
                microtime(true)
            ];
            $log->export();
        }
        //todo记录错误日志到数据表
        AppLogServices::addErrorLog(\Yii::$app->id,$err_msg);
        //return '错误页面<br />错误信息'.$err_msg;
        return $this->render('error',['err_msg'=>$err_msg]);
    }
}
