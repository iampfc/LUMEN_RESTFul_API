<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use App\Models\Rest;

class Ag extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public static $appID        = 'ICETEST0-DCBE-4A02-9800-D9C24F880E56';
    public static $token        = 'BE034A6CBF8FA3F7C529';
    public static $host         = 'http://holden.ag.listcloud.cn';
    public static $apiVersion   = 'v1';
    public static $encrypt      = 'commonICE';

    static public function getUrl($url)
    {
        return self::$host . '/' . self::$apiVersion . $url;
    }

    static public function getTs() {
        return time();
    }

    static public function getSign($ts)
    {
        return md5(self::$appID . $ts . self::$token . self::$encrypt);
    }

    /***************************发送短信**************************/
    static public function sendSms($mobile,$purpose,$message = ''){
        $url = self::getUrl('/sms/send');
        $ts = self::getTs();
        $option = array(
            'mobile'   => $mobile,
            'purpose'  => $purpose,
            'message'  => $message,
            'sign'     => self::getSign($ts),
            'ts'       => $ts,
            'appID'    => self::$appID
        );

        $result = \App\Models\Rest::curl($url,'POST',$option);
        $data = json_decode($result);
        if($data->code == 0){
            return true;
        }
        return false;
    }

}
