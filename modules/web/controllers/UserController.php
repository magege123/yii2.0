<?php

namespace app\modules\web\controllers;

use app\models\User;
use app\common\services\UrlService;
use app\modules\web\controllers\common\BaseController;

/**
 * Default controller for the `web` module
 */
class UserController extends BaseController
{
    public $layout = 'main';
    //登录
    public function actionLogin(){
        $this->layout = false;
        if(\Yii::$app->request->isPost){
            //登录逻辑处理
            $login_name = trim($this->post('login_name',''));
            $login_pwd = trim($this->post('login_pwd',''));
            if(!$login_name || !$login_pwd){
                return $this->renderJs('用户名或密码错误-1~~',UrlService::buildWebUrl('/user/login'));
            }
            //判断用户表$login_name = login_name的记录是否存在
            $user_info = User::find()->where(['login_name' => $login_name])->one();
            if(!$user_info){
                return $this->renderJs('用户名或密码错误-2~~',UrlService::buildWebUrl('/user/login'));
            }
            //验证密码 login_pwd=md5(用户输入密码+md5(数据库盐值))
            $auth_pwd = $user_info->getSaltPwd($login_pwd);
            if(!$user_info->verify($login_pwd)){
                return $this->renderJs('用户名或密码错误-3~~',UrlService::buildWebUrl('/user/login'));
            }
            //使用cookies保存用户登录状态
            $this->setLoginStatus($user_info);
            $this->redirect(UrlService::buildWebUrl('/dashboard/index'));
        }else{
            //return 111;
            return $this->render('login');
        }

    }

    //编辑当前登录用户信息
    public function actionEdit(){
        if(\Yii::$app->request->isGet){
            return $this->render('edit',['user_info'=>$this->current_user]);
        }
        $nickname = trim($this->post('nickname',''));
        $email = trim($this->post('email',''));

        if(mb_strlen($nickname,'utf-8')<1){
            $this->renderJson('请输入正确的用户名~~',-1);
        }

        if(mb_strlen($email,'utf-8')<1){
            $this->renderJson('请输入正确的邮箱~~',-1);
        }

        $user_info = $this->current_user;
        $user_info->nickname = $nickname;
        $user_info->email = $email;
        $user_info->updated_time = date('Y-m-d H:i:s');
        $user_info->update(0);
        $this->renderJson('信息修改成功~~');
    }

    //重置密码
    public function actionResetPwd(){
        if(\Yii::$app->request->isGet){
            return $this->render('reset_pwd',['user_info'=>$this->current_user]);
        }
        $old_password = trim($this->post('old_password',''));
        $new_password = trim($this->post('new_password',''));

        if(mb_strlen($old_password,'utf-8')<1){
            $this->renderJson('请输入正确的密码~~',-1);
        }

        if(mb_strlen($new_password,'utf-8')<6){
            $this->renderJson('新密码不能少于6位~~',-1);
        }

        if($old_password == $new_password){
            $this->renderJson('新密码与老密码重复了,请重新输入~~',-1);
        }

        //验证原始密码
        $user_info = $this->current_user;
        if(!$user_info->verify($old_password)){
            $this->renderJson('原始密码错误~~',-1);
        }

        $user_info->setNewPwd($new_password);
        $user_info->updated_time = date('Y-m-d H:i:s');
        $user_info->update(0);
        $this->setLoginStatus($user_info);

        $this->renderJson('密码修改成功~~');

    }

    //退出系统，删除cookie
    public function actionLogout(){
        $this->removeCookie('mooc_book');
        return $this->redirect(UrlService::buildWebUrl('/user/login'));
    }
}
