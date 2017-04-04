<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * 通过id查询运维人员(管理员)信息
     * @param $id
     * @return bool
     */
    static public function getByID($id)
    {
        $result = \DB::table(TABLE_ADMIN)->where('id',$id)->get();
        if($result->isEmpty()) return false;
        return $result->first();
    }

    /**
     * 通过账号查询运维人员(管理员)信息
     * @param $account
     * @return bool
     */
    static public function getByAccount($account)
    {
        $result = \DB::table(TABLE_ADMIN)->where('account',$account)->get();
        if($result->first()) return false;
        return true;
    }

    /**
     * 通过ID或者账号查询运维人员(管理员)信息
     * @param $id
     * @return bool
     */
    static public function getByIDOrAccount($id){
        $result = \DB::table(TABLE_ADMIN)
            ->where('id','=',$id)
            ->orWhere('account','=',$id)
            ->get();
        if($result->isEmpty()) return false;
        return $result->first();
    }

    /**
     * 通过公司名称获取此公司名称下的所有账号信息
     * @param $company
     * @return bool
     */
    static public function getByCompany($company)
    {
        $result = \DB::table(TABLE_ADMIN)->where('company',$company)->get();
        if($result->isEmpty()) return false;
        return $result;
    }

    /**
     * 创建运维人员(管理员)
     * @param $input
     * @return mixed
     */
    static public function create($input)
    {
        $lastInsertID = \DB::table(TABLE_ADMIN)->insertGetId(
            [
                'account' => $input['account'],
                "password" => $input['password'],
                'name' => $input['name'],
                'company' => $input['company'],
                'mobile' => $input['mobile']
            ]
        );
        return $lastInsertID;
    }

}
