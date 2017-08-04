<?php
namespace app\common\components;
use yii\web\Controller;
class BaseWebController extends Controller{

    protected $cookie_openid = 'cookie_openid';

    /*
     * 集成常用的方法供所有的Controller使用
     * */
    public $enableCsrfValidation = false;
    //获取http的get参数
    public function get($key,$default_val = ''){
        return \Yii::$app->request->get($key,$default_val);
    }
    //获取http的post参数
    public function post($key,$default_val = ''){
        return \Yii::$app->request->post($key,$default_val);
    }
    //设置cookie
    public function setCookie($name,$value,$expire = 0)
    {
        return \Yii::$app->response->cookies->add(new \yii\web\cookie([
            'name' => $name,
            'value' => $value,
            'expire' => $expire
        ]));
    }
    //获取cookie
    public function getCookie($name,$default_val = ''){
        return \Yii::$app->request->cookies->getValue($name,$default_val);
    }
    //删除cookie
    public function removeCookie($name){
        return \Yii::$app->response->cookies->remove($name);
    }
    //api统一返回json格式方法
    public function renderJson($msg = 'ok',$code = 200,$data = []){
        header('content-type:application/json');
        echo json_encode([
            'code'=>$code,
            'msg'=>$msg,
            'data'=>$data,
            'req_id'=>uniqid(),
        ]);
    }
    //统一js方法
    public function renderJs($msg,$url){
        return $this->render('@app/views/common/js',['msg'=>$msg,'url'=>$url]);
    }
    //设置登录态
    public function setLoginStatus($user_info){
        $auth_token = $this->setAuth($user_info);
        $this->setCookie('mooc_book',$auth_token.'#'.$user_info['uid']);
    }
    //统一auth_token方法
    public function setAuth($user_info){
        return md5($user_info['login_name'].$user_info['login_pwd'].$user_info['login_salt']);
    }
}