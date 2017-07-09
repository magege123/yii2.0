<?php

namespace app\modules\m\controllers;

use yii\web\Controller;

/**
 * Default controller for the `m` module
 */
class DefaultController extends Controller
{
   public $layout = 'main';
    public function actionIndex()
    {
        return $this->render('index');
    }
}
