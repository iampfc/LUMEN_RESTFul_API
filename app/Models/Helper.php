<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Helper extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    static public function now()
    {
        return date(DT_DATETIME1);
    }

    /**
     * Create a strong password hash with md5.
     * @param $account
     * @param $password
     * @return string
     */
    static public function signPassword($account,$password){
        return md5(md5($password) . $account);
    }

}
