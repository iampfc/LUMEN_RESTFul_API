<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Rest extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    static public function curl($url, $type = 'GET', $option = array(), $header = array())
    {
        if($type == 'GET' && $option)
        {
            $query = '&';
            foreach($option as $k => $v) $query .= "$k=$v&";
            $query = substr($query, 0, -1);
            $url .= $query;
        }

        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)'); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // 设置HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);

        if($type != 'GET' && !empty($option))
        {
            $tmp = @json_decode($option);
            if(is_array($tmp) || is_object($tmp))
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $option); // json方式提交
            }else
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($option)); //以前用法
            }
        }

        $stime=microtime(true);
        $result = curl_exec($curl); // 执行操作
        $etime=microtime(true);
        $total=$etime-$stime;
        $str_total = var_export($total, TRUE);
        if(substr_count($str_total,"E"))
        {
            $float_total = floatval(substr($str_total,5));
            $total = $float_total/100000;
        }
        $logInfo = self::log(round($total, 2), $type, $url, $option, $result);
        $result = json_decode($result);
//        $result->log = $logInfo;
        $result = json_encode($result);
        return $result;
        curl_close ($curl); // 关闭CURL会话
    }

    static public function log($time, $type, $url, $option, $result)
    {
        /* Set the error info. */
        //$errorLog  = "\n" .'['. $time .'s]'. date('H:i:s') . " url: $url, type: $type, data:" . json_encode($option) . " result:$result";
        $errorLog  = "\n" .'['. $time .'s]'. date('H:i:s') . " url: $url, type: $type";
        /* Save to log file. */
        //$errorFile = 'log/curl_' . date('Ymd');
        $errorFile = $_SERVER['DOCUMENT_ROOT'] . '/data/log/curl_' . date('Ymd') . '.log';
        file_put_contents($errorFile, $errorLog, FILE_APPEND);
        return $errorLog;
    }

}
