<?php
namespace app\common\services;
use app\common\services\BaseService;

class UploadService extends BaseService {
    //根据文件进行上传
    public static function uploadByFile($file_name,$file_path,$bucket = ''){
        if(!$file_name){
            return self::_err('参数文件名是必须的~~');
        }

        if(!$file_path || !file_exists($file_path)){
            return self::_err('请输入合法的参数file_path~~');
        }

        $uploads_config = \Yii::$app->params['uploads'];
        if(!$uploads_config){
            return self::_err('指定参数bucket错误~~');
        }

        $file_ext = explode('.',$file_name);
        $file_ext = strtolower($file_ext[count($file_ext)-1]);
        $hash_key = md5(file_get_contents($file_path));
        $upload_dir_path = UtilService::getRootPath().'/web'.$uploads_config[$bucket];
        $folder_name = date('Ymd');
        $upload_dir = $upload_dir_path.$folder_name;
        if(!file_exists($upload_dir)){
            mkdir($upload_dir,'0777');
            chmod($upload_dir,'0777');
        }

        $file_full_name = $folder_name.'/'.$hash_key.'.'.$file_ext;
        if(is_uploaded_file($file_path)){
            move_uploaded_file($file_path,$upload_dir_path.$file_full_name);
        }else{
            file_put_contents($upload_dir_path.$file_full_name,file_get_contents($file_path));
        }

        return [
            'code'=>200,
            'path'=>$file_full_name,
            'prefix'=>$uploads_config[$bucket]
        ];

    }
}