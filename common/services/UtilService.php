<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5 0005
 * Time: 下午 17:32
 */

namespace app\common\services;


use yii\helpers\Html;

class UtilService
{
    //返回ip
    public static function getIP(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    //转义特殊字符
    public static function encode($display){
        return Html::encode($display);
    }

    //获取根目录
    public static function getRootPath(){
        return dirname(\Yii::$app->vendorPath);
    }
}