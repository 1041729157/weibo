<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

    public function __construct(){
        //只允许未登陆用户访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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

    	//attempt 方法可接收两个参数，第一个参数为需要进行用户身份认证的数组，第二个参数为是否为用户开启『记住我』功能的布尔值
    	//-->if (Auth::attempt(['email' => $email, 'password' => $password]))
    	// if (Auth::attempt($credentials, $request->has('remember'))) {
        if (Auth::attempt($credentials, 'true')) {
            if (Auth::user()->activated) {
                session()->flash('success','欢迎回来--'.Auth::user()->name);
                $fallback = route('users.show', Auth::user());
                // return redirect()->route('users.show',[Auth::user()]);
                //redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上
                return redirect()->intended($fallback);
            }else{
                Auth::logout();
                session()->flash('danger', '您的账号未激活，请检查邮箱中的邮件进行激活！');
                return redirect()->route('login');
            }
    	}else{
    		session()->flash('danger','您的邮箱和密码不匹配');
    		//使用 withInput() 后模板里 old('email') 将能获取到上一次用户提交的内容
    		return redirect()->back()->withInput();
    	}
    	
    	/*attempt 方法执行的代码逻辑如下：

		1.使用 email 字段的值在数据库中查找；
		2.如果用户被找到：
			1). 先将传参的 password 值进行哈希加密，然后与数据库中 password 字段中已加密的密码进行匹配；
			2). 如果匹配后两个值完全一致，会创建一个『会话』给通过认证的用户。会话在创建的同时，也会种下一个名为 laravel_session 的 HTTP Cookie，以此 Cookie 来记录用户登录状态，最终返回 true；
			3). 如果匹配后两个值不一致，则返回 false；
		3.如果用户未找到，则返回 false。*/
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success', '退出登陆成功！');
        return redirect()->route('login');
    }
}
