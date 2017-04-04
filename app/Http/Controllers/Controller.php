<?php

namespace App\Http\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //
    public function __construct()
    {
        require __DIR__.'/../../../bootstrap/error.php';
        $this->customConfig = $customConfig;
    }

    /**
     * Create a strong password hash with md5.
     * @param $account
     * @param $password
     * @return string
     */
    public function signPassword($account,$password){
        return md5(md5($password) . $account);
    }

    public function success($content = '',$message = '请求成功'){
        $data = array('code'=>0);
        $data['message'] = $message;
        $data['content'] = $content;
        return $data;
    }

    public function error($key,$params = array(),$resetCode = null){
        $error = $this->customConfig->errors->{$key};
        if($key == 'vaildFail'){
            $error['validation'] = $params;
        }elseif(count($params) > 0){
            $error['message'] = sprintf($error['message'],...$params); //php5.6+
        }

        if($resetCode != null){
            $error['code'] = $resetCode;
        }
        return $error;
    }

}
