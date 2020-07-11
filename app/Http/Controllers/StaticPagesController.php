<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    //extends 是继承某个类,继承之后可以使用父类的方法,也可以重写父类的方法
 	public function home(){
 		return view('static_pages/home');
 		//渲染在 resources/views 文件夹下的 static_pages/home.blade.php 文件
 	}

 	public function help(){
 		return view('static_pages/help');
 	}

 	public function about(){
 		return view('static_pages/about');
 	}

}
