<?php

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Default controller for the `web` module
 */
class QrcodeController extends BaseController
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
}
