<?php

namespace app\modules\m\controllers;

use app\models\brand\BrandImages;
use app\models\brand\BrandSetting;
use app\modules\m\controllers\common\BaseController;

/**
 * Default controller for the `m` module
 */
class DefaultController extends BaseController
{
   public $layout = 'main';
    public function actionIndex(){
        $info = BrandSetting::find()->one();
        $image_list = BrandImages::find()->orderBy(['id'=>SORT_DESC])->all();
        return $this->render('index',[
            'info'=>$info,
            'image_list'=>$image_list
        ]);
    }
}
