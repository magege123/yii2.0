<?php

namespace app\controllers;

use Faker\Provider\Base;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\common\components\BaseWebController;

class IndexController extends BaseWebController
{
    //public $layout = true;
    public function actionIndex(){
        return $this->render('index');
    }
}
