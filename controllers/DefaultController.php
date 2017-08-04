<?php

namespace app\controllers;

use app\common\services\ConstantService;
use app\common\services\UtilService;
use Faker\Provider\Base;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\common\components\BaseWebController;
use app\common\services\captcha\ValidateCode;
use app\models\sms\SmsCaptcha;

class DefaultController extends BaseWebController
{
    private $validate_code = "validate_code";

    //生成图形验证码
    public function actionImg_captcha(){
        $base_dir = \Yii::$app->basePath;
        $path = $base_dir."/web/fonts/captcha.ttf";
        $captcha = new ValidateCode($path);
        $captcha->doimg();
        $this->setCookie($this->validate_code,$captcha->getCode(),time()+60*10);
    }

    public function actionGet_captcha(){
        $mobile = $this->post('mobile','');
        $img_captcha = $this->post('img_captcha','');

        if(!$mobile || !preg_match('/^1[0-9]{10}$/',$mobile)){
            $this->removeCookie($this->validate_code);
            return $this->renderJson('请输入正确的手机号2~~',-302);
        }

        $captcha_code = $this->getCookie($this->validate_code,'');
        if($captcha_code != strtolower($img_captcha)){
            $this->removeCookie($this->validate_code);
            return $this->renderJson("请输入正确的验证码\n\r您输入的验证码是{$img_captcha}正确的验证码是{$captcha_code}",-302);
        }

        //发送手机验证码，能发送验证，能验证是否正确
        $model_sms = new SmsCaptcha();
        $model_sms->geneSmsCode($mobile,UtilService::getIP());
        $this->removeCookie($this->validate_code);
        if($model_sms){
            return $this->renderJson("发送成功,验证码为{$model_sms->captcha}~~");
        }

        return $this->renderJson(ConstantService::$default_syserror);
    }

}
