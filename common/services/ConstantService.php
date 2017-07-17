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
            0=>'删除'
        ];
    public static $status_default = -1;
    public static $default_avatar = "default_avatar";
    public static $login_pwd = "******";
}