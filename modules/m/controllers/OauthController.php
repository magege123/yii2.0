<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26 0026
 * Time: 上午 11:39
 */

namespace app\modules\m\controllers;


use app\common\components\BaseWebController;
use app\common\services\UrlService;
use Behat\Gherkin\Loader\YamlFileLoader;

class OauthController extends BaseWebController
{
    public function actionLogin(){
        $scope = $this->get('scope','snsapi_base');
        $appid = \Yii::$app->params['weixin']['AppId'];
        $redirect_uri = UrlService::buildMUrl('/oauth/callback');

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=#wechat_redirect";
        $this->redirect($url);
    }

    public function actionCallback(){
        return '123';
    }

}