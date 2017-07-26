<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24 0024
 * Time: 下午 16:17
 */

namespace app\modules\weixin\controllers;


use app\common\components\BaseWebController;

class MsgController extends BaseWebController {
    public function actionIndex(){
        $res = $this->checkSignature();
        if(!$res){
            return 'error signature';
        }

        if(array_key_exists('echostr',$_GET) && $_GET['echostr']){
            return $_GET['echostr'];
        }
    }

    //验证消息的确来自微信服务器
    public function checkSignature(){
        $signature = trim($this->get('signature',''));
        $timestamp = trim($this->get('timestamp',''));
        $nonce = trim($this->get('nonce',''));
        $token = \Yii::$app->params['weixin']['Token'];
        $tmpArr = [$token,$timestamp,$nonce];
        sort($tmpArr);
        $result = implode('',$tmpArr);
        $result = sha1($result);

        if($result == $signature){
            return true;
        }else{
            return false;
        }
    }
}