<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * 通过id查询用户信息
     * @param $id
     * @return bool
     */
    static public function getByID($id)
    {
        $result = \DB::table(TABLE_USER)->where('id',$id)->get();
        if($result->isEmpty()) return false;
        return $result->first();
    }

    /**
     * 通过账号查询用户信息
     * @param $account
     * @return bool
     */
    static public function getByAccount($account)
    {
        $result = \DB::table(TABLE_USER)->where('account',$account)->get();
        if($result->first()) return false;
        return true;
    }

    /**
     * 通过公司名称获取此公司名称下的所有账号信息
     * @param $company
     * @return bool
     */
    static public function getByCompany($company)
    {
        $result = \DB::table(TABLE_USER)->where('company',$company)->get();
        if($result->isEmpty()) return false;
        return $result;
    }

    /**
     * 创建用户
     * @param $input
     * @return mixed
     */
    static public function create($data)
    {
        $lastInsertID = \DB::table(TABLE_USER)->insertGetId(
            [
                'account' => $data['account'],
                "password" => $data['password'],
                'name' => $data['name'],
                'company' => $data['company'],
                'mobile' => $data['mobile']
            ]
        );

        //如果有设置对应的运维人员则关联起来
        if ($data['admin_id'])
        {
            $result = \DB::table(TABLE_USER_ADMIN_RELATION)->insert(
                [
                    'user_id' => $lastInsertID,
                    "admin_id" => $data['admin_id'],
                ]
            );
        }
        return $lastInsertID;
    }

}
