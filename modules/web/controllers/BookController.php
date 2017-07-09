<?php

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Default controller for the `web` module
 */
class BookController extends BaseController
{
    public $layout = 'main';
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSet()
    {
        return $this->render('set');
    }
    public function actionInfo()
    {
        return $this->render('info');
    }
    public function actionImages()
    {
        return $this->render('images');
    }
    public function actionCat()
    {
        return $this->render('cat');
    }
    public function actionCat_set()
    {
        return $this->render('cat_set');
    }
}
