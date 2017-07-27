<?php
namespace app\common\services\weixin;
use app\common\components\HttpClient;
use app\common\services\BaseService;
use app\models\member\OauthAccessToken;

class RequestService extends BaseService {
    private static $app_token = '';
    private static $app_id = '';
    private static $app_secret = '';
    private static $url = 'https://api.weixin.qq.com/cgi-bin/';

    public static function getAccessToken(){
        $date_now = date('Y_m-d H:i:s');
        $access_token_info = OauthAccessToken::find()->where(['>','expired_time',$date_now])->limit(1)->one();

        if($access_token_info){
            return $access_token_info['access_token'];
        }

        //通过api接口获取access_token
        $access_token = self::send('token?grant_type=client_credential&appid='.self::getAppId().'&secret='.self::getAppSecret());
        if(!$access_token){
            return self::_err(self::getLastErrorMsg());
        }

        $model_access_token = new OauthAccessToken();
        $model_access_token->access_token = $access_token['access_token'];
        $model_access_token->expired_time = date('Y-m-d H:i:s',$access_token['expires_in']+time()-200);
        $model_access_token->created_time = $date_now;
        $model_access_token->save(0);
        return $access_token['access_token'];
    }

    public static function send($path,$data = [],$method = 'GET'){
        $request_url = self::$url.$path;
        if($method == 'POST'){
            $res = HttpClient::post($request_url,$data);
            var_dump($res);die;
        }else{
            $res = HttpClient::get($request_url,[]);
        }

        $ret = @json_decode($res,true);

        if(!$ret || (isset($ret['errcode']) && $ret['errcode'])){
            return self::_err($ret['errmsg']);
        }

        return $ret;
    }

    public static function setConfig($appid,$app_token,$secret){
        self::$app_id = $appid;
        self::$app_token = $app_token;
        self::$app_secret = $secret;
    }

    /**
     * @return string
     */
    public static function getAppToken()
    {
        return self::$app_token;
    }

    /**
     * @return string
     */
    public static function getAppId()
    {
        return self::$app_id;
    }

    /**
     * @return string
     */
    public static function getAppSecret()
    {
        return self::$app_secret;
    }
}