<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7 0007
 * Time: 下午 14:53
 */

namespace app\common\services;


class ConstantService
{
    public static $status_map = [
            1=>'正常',
            0=>'已删除'
        ];

    public static $sex_map = [
        0=>'未填写',
        1=>'男',
        2=>'女'
    ];
    public static $status_default = -1;
    public static $default_avatar = "default_avatar";
    public static $login_pwd = "******";
    public static $default_syserror = "系统繁忙，请稍后再试~~";
    public static $wechat = 1;
}