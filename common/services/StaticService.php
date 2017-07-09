<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7 0007
 * Time: 上午 10:25
 */

namespace app\common\services;


class StaticService
{
    //加载本身的资源文件
    public static function loadAppJsFile($path,$depend){
        self::loadAppFile('js',$path,$depend);
    }

    public static function loadAppCssFile($path,$depend){
        self::loadAppFile('css',$path,$depend);
    }

    public static function loadAppFile($type,$path,$depend){
        $release_version = defined("RELEASE_VERSION")?RELEASE_VERSION:time();
        if($type == 'js'){
            \Yii::$app->getView()->registerJsFile($path."?ver=".$release_version,$depend);
        }else{
            \Yii::$app->getView()->registerCssFile($path."?ver=".$release_version,$depend);
        }
    }
}