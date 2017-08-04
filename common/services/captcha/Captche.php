<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27 0027
 * Time: 下午 15:36
 */

namespace app\common\services\captcha;


class Captcha{
    private $charset = "abcdefghjkmnprstuvwxyzABCDEFGHKMNOPRSTUVWXYZ23456789身材最矮胖的一个性格温和可爱";
    private $code;//验证码
    private $codelen = 4;//长度
    private $width = 100;//宽度
    private $height = 37;//高度
    private $img;//图形资源句柄
    private $font;//字体
    private $fontsize = 28;//字体大小
    private $fontcolor;//字体颜色

    //构造方法初始化
    public function __construct($path=''){
        $this->font = $path;
    }

    //生成随机验证码
    private function createCode(){
        $len = strlen($this->charset) - 1;
        for($i=0;$i<$this->codelen;$i++){
            $this->code .= $this->charset[mt_rand(0,$len)];
        }
    }

    //生成背景
    private function createBg(){
        $this->img = imagecreatetruecolor($this->width,$this->height);
        $color = imagecolorallocate($this->img,255,255,255);
        imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
    }

    //生成文字
    private function createFont(){
        $x = $this->width/$this->codelen;
        for($i=0;$i<$this->codelen;$i++){
            $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$i*$x+mt_rand(1,5),$this->height,$this->fontcolor,$this->font,$this->code[$i]);
        }
    }

    //生成线条，雪花
    private function createLine(){
        //线条
        for($i=0;$i<6;$i++){
            $color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
            imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }

        //雪花
        for($i=0;$i<100;$i++){
            $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
            imagestring($this->img,mt_rand(0,5),mt_rand(0,$this->height),'*',$color);
        }
    }

    //输出
    private function outPut(){
        header(" content-type:image/png");
        imagepng($this->img);
        imagedestroy($this->img);
    }

    //对外生成
    public function doimg(){
        $this->createBg();
        $this->createCode();
        $this->createFont();
        $this->createLine();
        $this->outPut();
    }

    //获取验证码
    public function getCode(){
        return strtolower($this->code);
    }
}

