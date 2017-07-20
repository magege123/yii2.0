<?php
namespace app\modules\web\controllers;
use app\common\services\UploadService;
use app\common\services\UrlService;
use app\common\services\UtilService;
use app\modules\web\controllers\common\BaseController;

class UploadController extends BaseController {
    //上传接口
    //$bucket  avatar book brand
    private $allow_file_ext = ['jpg','jpeg','png','gif'];
    public function actionPic(){
        $bucket = trim($this->post("bucket",""));
        if(!$_FILES || !isset($_FILES['pic'])){
            return "<script>window.parent.upload.error('请选择文件后再上传~~')</script>";
        }

        $file_name = $_FILES['pic']['name'];
        $file_ext = explode('.',$file_name);
        if(!in_array(strtolower(end($file_ext)),$this->allow_file_ext)){
            return "<script>{$callback}.error('请选择正确的文件类型,文件类型包括jpg,jpeg,gif,png')</script>";
        }

        //todo图片上传业务逻辑编写
        $res = UploadService::uploadByFile($file_name,$_FILES['pic']['tmp_name'],$bucket);
        if(!$res){
            return "<script>window.parent.upload.error('".UploadService::getLastErrorMsg()."')</script>";
        }else{
            return "<script>window.parent.upload.success('".$res['path']."')</script>";
        }
    }
}