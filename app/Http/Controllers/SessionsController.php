<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function create(){
    	return view('sessions.create');
    }

    public function store(Request $request){
    	//当一个对象调用其方法时，该方法执行之前会想完成一个绑定，$this-->绑定到调用此方法的对象
    	//将验证后的数据赋值给变量 $credentials
    	$credentials = $this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    	]);

    	//attempt 方法会接收一个数组来作为第一个参数，该参数提供的值将用于寻找数据库中的用户数据
    	//-->if (Auth::attempt(['email' => $email, 'password' => $password]))
    	if (Auth::attempt($credentials)) {
    		session()->flash('success','欢迎回来--'.Auth::user()->name);
    		return redirect()->route('users.show',[Auth::user()]);
    	}else{
    		session()->flash('danger','您的邮箱和密码不匹配');
    		//使用 withInput() 后模板里 old('email') 将能获取到上一次用户提交的内容
    		return redirect()->back()->withInput();
    	}
    }
}
