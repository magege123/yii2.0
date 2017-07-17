<?php

namespace app\modules\web\controllers;

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
        $mobile = trim($this->post('mobile',''));
        $address = trim($this->post('address',''));
        $description = trim($this->post('description',''));
        $date = date('Y-m-d H:i:s');

        if(mb_strlen($name,'utf-8') < 1){
            return $this->renderJson('请输入合法的品牌名称~~',-302);
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
        return $this->render('images');
    }
}
