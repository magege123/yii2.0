<?php

namespace app\modules\web\controllers;

use app\common\services\ConstantService;
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
        //简单测试
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

        $total = $query->count();
        $page_size = 10;
        $pages = ceil($total/$page_size);

        $list = $query->orderBy(['uid'=>SORT_DESC])
            ->offset(($p-1)*$page_size)
            ->limit($page_size)
            ->all();
        return $this->render('index',[
            'list'=>$list,
            'status'=>$status,
            'mix_kw'=>$mix_kw,
            'page'=>[
                'total'=>$total,
                'page_size'=>$page_size,
                'p'=>$p,
                'pages'=>$pages
            ]
        ]);
    }
    //用户信息编辑
    public function actionSet()
    {
        return $this->render('set');
    }
    //用户信息详情
    public function actionInfo()
    {
        return $this->render('info');
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
