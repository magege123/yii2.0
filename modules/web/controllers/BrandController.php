<?php

namespace app\modules\web\controllers;

use app\common\services\ConstantService;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\models\brand\BrandImages;
use app\models\brand\BrandSetting;
use app\modules\web\controllers\common\BaseController;

/**
 * Default controller for the `web` module
 */
class BrandController extends BaseController
{
    public $layout = 'main';
    //品牌详情
    public function actionInfo()
    {
        $info = BrandSetting::find()->one();
        return $this->render('info',[
            'info'=>$info
        ]);
    }

    //编辑品牌
    public function actionSet()
    {
        if(\Yii::$app->request->isGet){
            $info = BrandSetting::find()->one();
            return $this->render('set',[
                'info'=>$info
            ]);
        }

        $name = trim($this->post('name',''));
        $image_key = trim($this->post('image_key',''));
        $mobile = trim($this->post('mobile',''));
        $address = trim($this->post('address',''));
        $description = trim($this->post('description',''));
        $date = date('Y-m-d H:i:s');

        if(mb_strlen($name,'utf-8') < 1){
            return $this->renderJson('请输入合法的品牌名称~~',-302);
        }

        if(mb_strlen($image_key,'utf-8') < 1){
            return $this->renderJson('请上传品牌logo~~',-302);
        }

        if(mb_strlen($mobile,'utf-8') < 1){
            return $this->renderJson('请输入合法的电话号码~~',-302);
        }

        if(mb_strlen($address,'utf-8') < 1){
            return $this->renderJson('请输入合法的地址~~',-302);
        }

        if(mb_strlen($description,'utf-8') < 1){
            return $this->renderJson('请输入合法的品牌介绍~~',-302);
        }

        $info = BrandSetting::find()->one();
        if($info){//编辑
            $model_brand = $info;
        }else{//添加
            $model_brand = new BrandSetting();
            $model_brand->created_time = $date;
        }

        $model_brand->name = $name;
        $model_brand->logo = $image_key;
        $model_brand->mobile = $mobile;
        $model_brand->address = $address;
        $model_brand->description = $description;
        $model_brand->updated_time = $date;

        $model_brand->save(0);
        $this->renderJson("操作成功~~",200);

    }

    //品牌图库
    public function actionImages()
    {
        $info = BrandImages::find()->orderBy(['id'=>SORT_ASC])->all();
        return $this->render('images',[
            'info'=>$info
        ]);
    }

    //上传图片
    public function actionSetImage(){
        $img_key = trim($this->post('img_key',''));
        if(!$img_key){
            return $this->renderJson('请选择上传图片~~',-302);
        }

        $count = BrandImages::find()->count();
        if($count >= 5){
            return $this->renderJson('最多上传5张图片~~',-302);
        }

        $brand_image = new BrandImages();
        $brand_image->image_key = $img_key;
        $brand_image->created_time = date('Y-m-d H:i:s');
        $brand_image->save(0);
        $this->renderJson('操作成功');
    }

    //删除图片
    public function actionImageOps(){
        if(!\Yii::$app->request->isPost){
            return $this->renderJson(ConstantService::$default_syserror,-302);
        }

        $id = trim($this->post('id',-1));
        if(!$id){
            return $this->renderJson('请选择要删除的图片~~',-302);
        }

        $info = BrandImages::find()->where(['id'=>$id])->one();
        if(!$info){
            return $this->renderJson('要删除的图片不存在~~',-302);
        }

        $info->delete();
        return $this->renderJson('操作成功~~');
    }
}
