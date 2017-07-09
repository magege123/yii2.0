<?php

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseController;

/**
 * Default controller for the `web` module
 */
class FinanceController extends BaseController
{
    public $layout = 'main';
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAccount()
    {
        return $this->render('account');
    }
    public function actionPay_info()
    {
        return $this->render('pay_info');
    }
}
