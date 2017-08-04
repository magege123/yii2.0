<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26 0026
 * Time: 上午 11:39
 */

namespace app\modules\m\controllers;


use app\common\components\BaseWebController;
use app\common\components\HttpClient;
use app\common\services\UrlService;
use Behat\Gherkin\Loader\YamlFileLoader;
use app\common\services\captcha\Captcha;

class OauthController extends BaseWebController
{
    public function actionLogin(){
        $scope = $this->get('scope','snsapi_base');
        $appid = \Yii::$app->params['weixin']['AppId'];
        $redirect_uri = UrlService::buildMUrl('/oauth/callback');

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionCallback(){
        $code = $this->get('code','');
        if(!$code){
            return $this->goHome();
        }

        $appid = \Yii::$app->params['weixin']['AppId'];
        $sk = \Yii::$app->params['weixin']['AppSecret'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$sk}&code={$code}&grant_type=authorization_code ";
        $res = HttpClient::get($url);
        $ret = @json_decode($res,true);

        $access_token = isset($ret['access_token'])?$ret['access_token']:'';
        if(!$access_token){
            return $this->goHome();
        }

        $openid = isset($ret['openid'])?$ret['openid']:'';
        $this->setCookie($this->cookie_openid,$openid);

        $scope = isset($ret['scope'])?$ret['scope']:'';
        if($scope == "snsapi_userinfo"){
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN ";
            $user_info = HttpClient::get($url);
        }

        return $this->redirect(UrlService::buildMUrl('/default/index'));
    }

}