<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Helper;
use App\Models\Token;
use App\Models\Ag;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * 客户端用户注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        //todo 获取输入值
        $data = $request->all();
        $data['name']    = $request->input('name', '');
        $data['address'] = $request->input('address', '');
        $data['email']   = $request->input('email', '');
        $data['avatar']  = $request->input('avatar', '');
        $data['gender']  = $request->input('gender', 'u');
        $data['join']    = $request->input('join', \App\Models\Helper::now());
        $data['last']    = $request->input('last', \App\Models\Helper::now());

        //todo 电话格式验证,密码格式验证等
        $validator = $this->validate($request, [
            'account'   => 'required|max:32',
            'password'  => 'required|password',
            'company'   => 'required',
            'mobile'    => 'required|mobile',
        ]);
        if($validator) return response()->json($this->error('vaildFail',$validator));
        $data['password'] = \App\Models\Helper::signPassword($data['account'],$data['password']);

        //todo 用户名验证
        $result = \App\Models\User::getByAccount($data['account']);
        if(!$result) return response()->json($this->error('createExist'));

        //todo 判断此公司名下是否已经有注册过的手机号
        $result = \App\Models\User::getByCompany($data['company']);
        if($result)
        {
            foreach ($result as $key => $value)
            {
                if($value->mobile == $data['mobile'])
                {
                    return response()->json($this->error('mobileExist'));
                }
            }
        }

        //todo 如果有关联专属运维则进行关联逻辑
        if(isset($data['admin_id']))
        {
            $admin = \App\Models\Admin::getByIDOrAccount($data['admin_id']);
            if (!$admin)
            {
                return response()->json($this->error('notFoundAdmin'));
            }
            $data['admin_id'] = $admin->id;
        }
        $lastInsertID =  \App\Models\User::create($data);
        $user = \App\Models\User::getByID($lastInsertID);
        if(!$user) return response()->json($this->error('registerFail'));
        $token = \App\Models\Token::awardToken($user->id);
        if($token === false){
            return $this->error('awardTokenFail');
        }

        return response()->json($this->success($user,'注册成功'));
    }

    /**
     * 客户端用户登录
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $account  = $request->input('account', '');
        $password = $request->input('password', '');
        $company  = $request->input('company', '');

        $validator = $this->validate($request, [
            'account'   => 'required',
            'password'  => 'required',
            'company'   => 'required',
        ]);
        if($validator) return response()->json($this->error('vaildFail',$validator));

        //TODO 支持用户名手机号码登录
        $user = \App\Models\User::getFrontLogin($account,$company);
        if(!$user) return $this->error('notFoundUser');
        $signPassword = \App\Models\Helper::signPassword($user->account,$password);
        if($user->password == $signPassword){
            if($user->locked != '0000-00-00 00:00:00'){
                return $this->error('disable');
            }
            $token = \App\Models\Token::awardToken($user->id);
            if($token === false){
                return $this->error('awardTokenFail');
            }else{
                unset($user->password);
                \DB::table(TABLE_USER)->where('id', $user->id)->update(['last' => \App\Models\Helper::now()]);
                return $this->success(
                    array(
                        'token' => $token,
                        'user'  => $user,
                    ),
                    '登录成功'
                );
            }
        }else{
            return $this->error('loginFail');
        }
    }

    public function test()
    {
        $result = \App\Models\Ag::sendSms('18965652853','register','验证您的手机号码,您的验证码是{code}');
        var_dump($result);
    }

    public function getByID($id)
    {
        $result = \App\Models\User::getByID($id);
        if(!$result) return response()->json($this->error('notFound'));
        return response()->json($this->success($result));
    }

    public function getList()
    {
        $pageID = 1;
        $pageSize = 10;
        $users = \DB::table(TABLE_USER)->skip(($pageID-1)* $pageSize)->take($pageSize)->get();
        return response()->json($this->success($users));

    }


    public function show($id)
    {
        //select
        $user = app('db')->select("SELECT * FROM user where id = $id");
//        $results = \DB::select('SELECT * FROM user where id = ? ', [2]);
//        $results = \DB::select('select * from user where id = :id', ['id' => 1]);

        //insert
//        $result = \DB::insert('insert into user (name, age) values (?, ?)', [ 'Dayle',15]);

        //update
//        $affected = \DB::update('update user set name = "lisi123" where id = ?', [24]);

        //delete
//        $deleted = \DB::delete('delete from user where id = ?',[$id]);

        $user = \DB::table('user')->get();

        if (!$user) {
            return response()->json('NOT FOUND');
        }
        return response()->json($user);
    }

//    public function create(Request $request,$id,$name)
//    {
//        $input = $request->all();   //获取全部输入
//        print_r($input);
//        $user_name = $request->input('user_name','李四');  //获取指定的输入值
//        if (!$request->has('user_name')) {
//            echo 'user_name 为空';
//        }
//
//        // 不包含请求字串
////        $url = $request->url();
//
//        // 包含请求字串（请求字串如：`?id=2`）
////        $fullUrl = $request->fullUrl();
//
////        print_r($url);
//    }
}