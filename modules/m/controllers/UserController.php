<?php

namespace app\modules\m\controllers;

use app\common\services\ConstantService;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\member\Member;
use app\models\member\OauthMemberBind;
use app\models\sms\SmsCaptcha;
use yii\web\Controller;
use app\common\components\BaseWebController;

/**
 * Default controller for the `m` module
 */
class UserController extends BaseWebController
{
    public $layout = 'main';
    public function actionBind()
    {
        if(\Yii::$app->request->isGet){
            return $this->render('bind');
        }

        $mobile = $this->post('mobile','');
        $img_captcha = $this->post('img_captcha','');
        $captcha_code = $this->post('captcha_code','');
        $openid = $this->getCookie($this->cookie_openid);
        $date_now = date('Y-m-d H:i:s');

        if(mb_strlen($mobile) < 1|| !preg_match('/^1[0-9]{10}$/',$mobile)){
            return $this->renderJson('请输入正确的手机号~~',-302);
        }

        if(mb_strlen($img_captcha) < 1){
            return $this->renderJson('请输入正确的图形验证码~~',-302);
        }

        if(mb_strlen($captcha_code) < 1){
            return $this->renderJson('请输入正确的手机验证码~~',-302);
        }

        if(!SmsCaptcha::checkCode($mobile,$captcha_code)){
            return $this->renderJson('请输入符合规范的手机验证码~~',-302);
        }

        $member_info = Member::findOne(['mobile'=>$mobile,'status'=>1]);
        if(!$member_info){
            if(Member::findOne(['mobile'=>$mobile])){
                $this->renderJson('该手机号已注册，请直接登录~~');
            }

            $model_member = new Member();
            $model_member->nickname = $mobile;
            $model_member->mobile = $mobile;
            $model_member->avatar = ConstantService::$default_avatar;
            $model_member->setSalt();
            $model_member->reg_ip = sprintf('%u',ip2long(UtilService::getIP()));
            $model_member->status = 1;
            $model_member->created_time = $date_now;
            $model_member->updated_time = $date_now;
            $model_member->save(0);
            $member_info = $model_member;
        }

        if(!$member_info){
            return $this->renderJSON("您的账号已被禁止，请联系客服解决~~", -302);
        }

        if($openid){
            $bind_info = OauthMemberBind::find()->where(['member_id'=>$member_info['id'],'type'=>ConstantService::$wechat,'openid'=>$openid])->one();

            if(!$bind_info){
                $model_bind = new OauthMemberBind();
                $model_bind->member_id = $member_info['id'];
                $model_bind->client_type = "weixin";
                $model_bind->type = ConstantService::$wechat;
                $model_bind->openid = $openid;
                $model_bind->unionid = '';
                $model_bind->extra = '';
                $model_bind->updated_time = $date_now;
                $model_bind->created_time = $date_now;
                $model_bind->save(0);
            }
        }

        return $this->renderJSON("绑定成功~~",200,['url'=>UrlService::buildMUrl('/default/index')]);

    }

    public function actionAddress()
    {
        return $this->render('address');
    }

    public function actionAddress_set()
    {
        return $this->render('address_set');
    }

    public function actionCart()
    {
        return $this->render('cart');
    }

    public function actionComment()
    {
        return $this->render('comment');
    }

    public function actionComment_set()
    {
        return $this->render('comment_set');
    }

    public function actionFav()
    {
        return $this->render('fav');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrder()
    {
        return $this->render('order');
    }
}
