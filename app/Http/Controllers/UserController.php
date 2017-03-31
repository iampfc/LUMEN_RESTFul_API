<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        if (!$user) {
            return response()->json('NOT FOUND');
        }
        return response()->json($user);
    }
}