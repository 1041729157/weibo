<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
	public function index(){
		return view('users.index');
	}

    public function create(){
    	return view('users.create');
    }

    //show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例
    public function show(User $user){
    	//compact — 建立一个数组，包括变量名和它们的值
    	return view('users.show', compact('user'));
    }
}
