<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;


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

    // Request 实例可以获取用户在表单中输入的值
    public function store(Request $request){
    	//validate 方法接收两个参数，第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则
    	$this->validate($request, [
    		//required 验证用户名是否为空；unique:users 数据唯一性验证； email 能够完成邮箱格式的验证；confirmed 来进行密码匹配验证，保证两次输入的密码一致
    		'name' => 'required|unique:users|max:50',
    		'email' => 'required|email|unique:users|max:255',
    		'password' => 'required|confirmed|min:6'
    	]);

    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    	]);

    	//注册成功后自动登陆
    	Auth::login($user);

    	// 使用 session() 方法来访问会话实例。而当我们想存入一条缓存的数据，让它只在下一次的请求内有效时
    	//flash 方法接收两个参数，第一个为会话的键，第二个为会话的值
    	session()->flash('success', '欢迎--'.$user->name);

    	//redirect()重定向操作；[$user] == [$user->id]
    	return redirect()->route('users.show', [$user]);
    }
}
