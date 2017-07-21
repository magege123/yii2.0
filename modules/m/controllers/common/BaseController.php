<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/21 0021
 * Time: 上午 10:14
 */

namespace app\modules\m\controllers\common;


use app\common\components\BaseWebController;

class BaseController extends BaseWebController
{
    public function beforeAction($action)
    {
        return true;
    }
}