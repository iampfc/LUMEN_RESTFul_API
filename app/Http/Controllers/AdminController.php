<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function getByID($id)
    {
        $result = \App\Models\User::getByID($id);
        if(!$result) return response()->json($this->error('notFound'));
        return response()->json($this->success($result));
    }

    public function getList()
    {
        $pageID = 2;
        $pageSize = 10;
        $users = \DB::table(TABLE_USER)->skip(($pageID-1)* $pageSize)->take($pageSize)->get();
        print_r($users);echo '<br>';

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