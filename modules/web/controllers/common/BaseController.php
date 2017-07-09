<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5 0005
 * Time: 下午 15:33
 */

namespace app\modules\web\controllers\common;


use app\common\components\BaseWebController;
use app\common\services\UrlService;
use app\models\User;


class BaseController extends BaseWebController{

    public $current_user = null;
    private $allowAction = ['web/user/login'];

    public function beforeAction($action){
        if(in_array($action->getUniqueId(),$this->allowAction)){
            return true;
        }

        $is_login = $this->checkLoginStatus();
        if(!$is_login){
            if(\Yii::$app->request->isAjax){
                $this->renderJson('请先登录~~',-302);
            }else{
                $this->redirect(UrlService::buildWebUrl('/user/login'));
            }
            return false;
        }
        return true;
    }

    private function checkLoginStatus(){
        $auth_cookie = $this->getCookie('mooc_book');
        if(!$auth_cookie){
            return false;
        }

        list($auth_token,$uid) = explode('#',$auth_cookie);
        if(!$auth_token || !$uid){
            return false;
        }

        if(!preg_match('/^\d+$/',$uid)){
            return false;
        }

        $user_info = User::find()->where(['uid'=>$uid])->one();
        $this->current_user = $user_info;
        if(!$user_info){
            return false;
        }

        $auth_token_md5 = $this->setAuth($user_info);
        if($auth_token_md5 != $auth_token){
            return false;
        }

        return true;
    }
}