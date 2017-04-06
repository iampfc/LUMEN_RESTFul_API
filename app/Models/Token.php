<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Token extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public static $isSingleLogin = false;  //配置是否是单用户登录
    public static  $expire = 3600;         //配置token到期时间

    static public function awardToken($id,$port = 'front'){
        $token = md5(time() * time() * mt_rand(10000,99999));

        //TODO 如果等于front,前端用户登录颁发token,否则是后端用户(给管理员颁发token)
        if($port == 'front') {
            if(self::$isSingleLogin)
                \DB::table(TABLE_TOKEN)->where('user_id', '=', $id)->delete();
            \DB::table(TABLE_TOKEN)->where('end_time', '<', time())->delete();  //删除失效的token
            $added = \DB::table(TABLE_TOKEN)->insert(
                [
                    'user_id' => $id,
                    'token'    => $token,
                    'end_time' => time()+self::$expire
                ]
            );
        }else {
            if(self::$isSingleLogin)
                \DB::table(TABLE_TOKEN)->where('admin_id', '=', $id)->delete();
            \DB::table(TABLE_TOKEN)->where('end_time', '<', time())->delete();  //删除失效的token
            $added = \DB::table(TABLE_TOKEN)->insert(
                [
                    'admin_id' => $id,
                    'token'    => $token,
                    'end_time' => time()+self::$expire
                ]
            );
        }

        if($added > 0){
            return $token;
        }else{
            return false;
        }
    }

}
