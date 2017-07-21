<?php

namespace app\modules\web\controllers;

use app\common\services\ConstantService;
use app\common\services\UrlService;
use app\models\log\AppAccessLog;
use app\models\User;
use app\modules\web\controllers\common\BaseController;

/**
 * Default controller for the `web` module
 */
class AccountController extends BaseController
{
    public $layout = 'main';
    //用户列表
    public function actionIndex()
    {
        $status = intval($this->get('status',ConstantService::$status_default));
        $mix_kw = trim($this->get('mix_kw',''));
        $p = intval($this->get('p',1));

        $query = User::find();
        if($status > ConstantService::$status_default){
            $query->andWhere(['status'=>$status]);
        }

        if($mix_kw){
            $where_nickname = ['like','nickname','%'.$mix_kw.'%',false];
            $where_email = ['like','mobile','%'.$mix_kw.'%',false];
            $query->andWhere(['or',$where_nickname,$where_email]);
        }

        $count = $query->count();
        $page_size = 10;
        $pages = ceil($count/$page_size);

        $list = $query->orderBy(['uid'=>SORT_DESC])
            ->offset(($p-1)*$page_size)
            ->limit($page_size)
            ->all();
        return $this->render('index',[
            'list'=>$list,
            'status'=>$status,
            'mix_kw'=>$mix_kw,
            'page'=>[
                'count'=>$count,
                'page_size'=>$page_size,
                'p'=>$p,
                'pages'=>$pages
            ]
        ]);
    }

    //用户信息编辑
    public function actionSet()
    {
        if(\Yii::$app->request->isGet){
            $id = $this->get('id',0);
            $info = [];
            if($id){
                $info = User::find()->where(['uid'=>$id])->one();
            }

            return $this->render('set',[
                'info'=>$info
            ]);
        }

        $id = intval($this->post('id',0));
        $nickname = trim($this->post("nickname",''));
        $mobile = trim($this->post("mobile",''));
        $email = trim($this->post("email",''));
        $login_name = trim($this->post("login_name",''));
        $login_pwd = trim($this->post("login_pwd",''));
        $date_now = date("Y-m-d H:i:s");

        if(mb_strlen($nickname,'utf-8')<1){
            $this->renderJson('请输入正确的用户名~~',-1);
            die;
        }

        if(mb_strlen($mobile,'utf-8')<1){
            $this->renderJson('请输入正确的手机号~~',-1);
            die;
        }

        if(mb_strlen($email,'utf-8')<1){
            $this->renderJson('请输入正确的邮箱~~',-1);
            die;
        }

        if(mb_strlen($login_name,'utf-8')<1){
            $this->renderJson('请输入正确的登录名~~',-1);
            die;
        }

        if(mb_strlen($login_pwd,'utf-8')<1){
            $this->renderJson('请输入正确的密码~~',-1);
            die;
        }

        $has_in = User::find()->where(['nickname'=>$nickname])->andWhere(['!=','uid',$id])->count();
        if($has_in){
            $this->renderJson('用户名已经存在，请重新输入~~',-1);
            die;
        }

        $info = User::find()->where(['uid'=>$id])->one();
        if($info){//编辑
            $model_user = $info;
        }else{//添加
            $model_user = new User();
            $model_user->setSalt();
            $model_user->created_time = $date_now;
        }


        $model_user->nickname = $nickname;
        $model_user->mobile = $mobile;
        $model_user->email = $email;
        $model_user->avatar = ConstantService::$default_avatar;
        $model_user->login_name = $login_name;
        if($login_pwd != ConstantService::$login_pwd){
            $model_user->setNewPwd($login_pwd);
        }
        $model_user->updated_time = $date_now;
        $model_user->save(0);
        $this->renderJson('操作成功~~',200);
    }

    //用户信息详情
    public function actionInfo()
    {
        $id = intval($this->get('id',''));
        $reback_url = UrlService::buildWebUrl("/account/index");
        if(!$id){
            $this->redirect($reback_url);
        }

        $info = User::find()->where(['uid'=>$id])->one();
        if(!$info){
            $this->redirect($reback_url);
        }

        $list = AppAccessLog::find()->where(['uid'=>$info['uid']])->orderBy(['id'=>SORT_DESC])->limit(10)->all();

        return $this->render('info',[
            'info'=>$info,
            'list'=>$list
        ]);
    }

    //用户操作
    public function actionOps(){
        if(!\Yii::$app->request->isPost){
            $this->renderJson('系统繁忙，请稍后再试~~',-1);
        }

        $act = trim($this->post('act',''));
        $uid = intval($this->post('uid',''));

        if(!in_array($act,['remove','recover'])){
            $this->renderJson('操作有误，请重试~~',-1);
        }

        if(!$uid){
            $this->renderJson('请选择要操作的账号~~',-1);
        }

        $user_info = User::find()->where(['uid'=>$uid])->one();
        if(!$user_info){
            $this->renderJson('您指定的账号不存在',-1);
        }

        switch($act){
            case 'remove':
                $user_info->status = 0;
                break;
            case "recover":
                $user_info->status = 1;
                break;
        }
        $user_info->updated_time = date("Y-m-d H:i:s");
        $user_info->update(0);
        $this->renderJson('操作成功~~',200);
    }
}
