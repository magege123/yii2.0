<?php

namespace app\modules\web\controllers;

use app\common\services\ConstantService;
use app\common\services\UtilService;
use app\models\member\Member;
use app\modules\web\controllers\common\BaseController;
use app\common\services\UrlService;

/**
 * Default controller for the `web` module
 */
class MemberController extends BaseController
{
    public $layout = 'main';

    //会员列表
    public function actionIndex()
    {
        /************************搜索**************************/
        $query = Member::find();
        $status = intval($this->get('status',ConstantService::$status_default));
        $mix_kw = trim($this->get('mix_kw',''));

        if($status > ConstantService::$status_default){
            $query->andWhere(['status'=>$status]);
        }

        if($mix_kw){
            $where_nickname = ['LIKE','nickname',"%".strtr($mix_kw,['%'=>'\%','_'=>'\_','\\'=>'\\\\'])."%",false];
            $where_mobile = ['LIKE','mobile',"%".strtr($mix_kw,['%'=>'\%','_'=>'\_','\\'=>'\\\\'])."%",false];
            $query->andWhere(['OR',$where_nickname,$where_mobile]);
        }
        /************************搜索**************************/

        /************************分页**************************/

        $p = intval($this->get('p',1));
        $p = ($p>0)?$p:1;
        $count = $query->count();
        $page_size = 10;
        $pages = ceil($count/$page_size);
        $mem_list =$query
            ->offset(($p-1)*$page_size)
            ->limit($page_size)
            ->orderBy(['id'=>SORT_DESC])
            ->all();
        /************************分页**************************/
        $data = [];
        foreach ($mem_list as $value){
            $data[] = [
                'id'=>$value['id'],
                'nickname'=>UtilService::encode($value['nickname']),
                'mobile'=>UtilService::encode($value['mobile']),
                'sex'=>ConstantService::$sex_map[$value['sex']],
                'status_desc'=>ConstantService::$status_map[$value['status']],
                'avatar'=>UrlService::buildPicUrl('avatar',$value['avatar']),
                'status'=>$value['status']
            ];
        }
        return $this->render('index',[
            'mem_list'=>$data,
            'page'=>[
                'page_size'=>$page_size,
                'count'=>$count,
                'pages'=>$pages,
                'p'=>$p
            ],
            'mix_kw'=>$mix_kw,
            'status'=>$status
        ]);
    }

    //会员编辑
    public function actionSet()
    {
        if(\Yii::$app->request->isGet){
            $id = intval($this->get('id',0));
            $info = [];
            if($id){
                $info = Member::findOne(['id'=>$id]);
            }
            return $this->render('set',[
                'info'=>$info
            ]);
        }

        $id = intval($this->post('id',0));
        $nickname = trim($this->post('nickname',''));
        $mobile = floatval($this->post('mobile',''));
        $date_now = date('Y-m-d H:i:s');

        $has_in = Member::find()->where(['nickname'=>$nickname])->andWhere(['!=','id',$id])->count();
        if($has_in){
            return $this->renderJson('用户名已存在，请重新输入~~',-302);
        }

        if(mb_strlen($nickname,'utf-8')<1){
            return $this->renderJson('请输入正确的会员名~~');
        }

        if(mb_strlen($mobile,'utf-8')<1){
            return $this->renderJson('请输入正确的手机号码~~');
        }

        $info = Member::find()->where(['id'=>$id])->one();
        if($info){
            //编辑
            $model_member = $info;
        }else{
            //添加
            $model_member = new Member();
            $model_member->created_time = $date_now;
            $model_member->avatar = ConstantService::$default_avatar;
            $model_member->status = 1;
        }

        $model_member->nickname = $nickname;
        $model_member->mobile = $mobile;
        $model_member->updated_time = $date_now;
        $model_member->save(0);
        $this->renderJson('操作成功~~');
    }

    //会员操作
    public function actionOps(){
        if(!\Yii::$app->request->isPost){
            $this->renderJson(ConstantService::$default_syserror,-302);
        }

        $id = intval($this->post('id',[]));
        $act = trim($this->post('act',''));

        if(!$id){
            return $this->renderJson('请选择需要操作的账号~~',-302);
        }

        if(!in_array($act,['remove','recover'])){
            return $this->renderJson('操作有误，请重试!~~',-302);
        }

        $info = Member::find()->where(['id'=>$id])->one();
        if(!$info){
            return $this->renderJson('指定的账号不存在!~~',-302);
        }

        switch($act){
            case 'remove':
                $info->status = 0;
                break;
            case 'recover':
                $info->status = 1;
                break;
        }

        $info->updated_time = date('Y-m-d H:i:s');
        $info->update(0);
        $this->renderJson('操作成功');
    }

    //会员详情
    public function actionInfo()
    {
        $id = intval($this->get('id',0));
        $reback_url = UrlService::buildWebUrl('/member/index');
        if(!$id){
            $this->redirect($reback_url);
        }

        $data = Member::find()->where(['id'=>$id])->one();
        if(!$data){
            $this->redirect($reback_url);
        }

        return $this->render('info',[
            'data'=>$data
        ]);
    }

    //会员评论
    public function actionComment()
    {
        return $this->render('comment');
    }
}
