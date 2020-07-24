<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;

    //重写重定向默认地址
    protected $redirectTo = '/';

    public function __construct(){
        $this->middleware('guest');
    }
}
