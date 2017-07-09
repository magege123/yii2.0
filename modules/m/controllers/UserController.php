<?php

namespace app\modules\m\controllers;

use yii\web\Controller;

/**
 * Default controller for the `m` module
 */
class UserController extends Controller
{
    public $layout = 'main';
    public function actionBind()
    {
        return $this->render('bind');
    }

    public function actionAddress()
    {
        return $this->render('address');
    }

    public function actionAddress_set()
    {
        return $this->render('address_set');
    }

    public function actionCart()
    {
        return $this->render('cart');
    }

    public function actionComment()
    {
        return $this->render('comment');
    }

    public function actionComment_set()
    {
        return $this->render('comment_set');
    }

    public function actionFav()
    {
        return $this->render('fav');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrder()
    {
        return $this->render('order');
    }
}
