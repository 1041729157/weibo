<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Mail;


class UsersController extends Controller
{

    public function __construct(){
        //middleware 方法，该方法接收两个参数，第一个为中间件的名称，第二个为要进行过滤的动作
        $this->middleware('auth',[
            //except 方法来设定 指定动作 不使用 Auth 中间件进行过滤(游客除以下页面之外均无法访问访问)
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);

        //仅限游客访问
        $this->middleware('guest', [
            'only' => ['create']
        ]);

    }

	public function index(User $user){
        // $users = User::all();
        // $users = $user->all();
        // $users = User::paginate(10);
        $users = $user->paginate(10);
        //$users = $user->simplePaginate(10);
		return view('users.index', compact('users'));
	}

    public function create(){
    	return view('users.create');
    }

    //show() 方法传参时声明了类型 —— Eloquent 模型 User，对应的变量名 $user 会匹配路由片段中的 {user}，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例
    public function show(User $user){
    	//compact — 建立一个数组，包括变量名和它们的值
    	return view('users.show', compact('user'));
        //等同于 return view('users.show', ['user' => $user]);
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

        //注册时给用户发送一个激活邮件
        $this->sendEmaiConfirmationTo($user);
        session()->flash('success', "验证邮件已经发送到你的注册邮箱上，请注意查收！");

        return redirect()->route('users.create');

    	//注册成功后自动登陆
    	// Auth::login($user);

    	// 使用 session() 方法来访问会话实例。而当我们想存入一条缓存的数据，让它只在下一次的请求内有效时
    	//flash 方法接收两个参数，第一个为会话的键，第二个为会话的值
    	// session()->flash('success', '欢迎--'.$user->name);

    	//redirect()重定向操作；[$user] == [$user->id]
    	// return redirect()->route('users.show', Auth::user()->id);
    }


    public function edit(User $user){
        //默认的 App\Http\Controllers\Controller 类包含了 Laravel 的 AuthorizesRequests trait。此 trait 提供了 authorize 方法
        //authorize 方法接收两个参数，第一个为授权策略的名称，第二个为进行授权验证的数据
        $this->authorize('update',$user);//'update'是UserPolicy.php授权策略中的update方法
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request){
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6|max:16'
        ]);

        /*$user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password)
        ]);*/
        $date = [];
        $date['name'] = $request->name;
        if($request->password){
            $date['password'] = bcrypt($request->password);
        }

        $user->update($date);

        session()->flash('success','个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    public function destroy(User $user){
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '用户删除成功！');
        return back();
    }

    protected function sendEmaiConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        // $from = '1041729157@qq.com';
        // $name = 'HH';
        $to = $user->email;
        $subject = "感谢注册，请确认您的邮箱！";

        /*Mail 的 send 方法接收三个参数：
        第一个参数是包含邮件消息的视图名称
        第二个参数是要传递给该视图的数据数组
        最后是一个用来接收邮件消息实例的闭包回调，我们可以在该回调中自定义邮件消息的发送者、接收者、邮件主题等信息*/
        /*Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });*/
        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token){

        //where 方法接收两个参数，第一个参数为要进行查找的字段名称，第二个参数为对应的值，查询结果返回的是一个数组，使用 firstOrFail 方法来取出第一个用户，在查询不到指定用户时将返回一个 404 响应
        $user = User::where('activation_token', $token)->firstOrfail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜激活成功!');
        $fallback = route('users.show', Auth::user()->id);
        return redirect()->intended($fallback);
    }
}
