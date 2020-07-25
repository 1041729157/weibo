<?php

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

// Route::get('/signup','UsersController@create')->name('signup');

/*Route::resource('users', 'UsersController');*/
//相当于以下：
//用户列表：
Route::get('/users','UsersController@index')->name('users.index');
//注册页：
Route::get('/users/create','UsersController@create')->name('users.create');
//个人信息页：{user}获取当前端$user传进来的值
Route::get('/users/{user}','UsersController@show')->name('users.show');
//创建用户：
Route::post('/users','UsersController@store')->name('users.store');
//编辑个人信息页：
Route::get('/users/{user}/edit','UsersController@edit')->name('users.edit');
//更新用户：
Route::patch('/users/{user}','UsersController@update')->name('users.update');
//删除用户：
Route::delete('/users/{user}','UsersController@destroy')->name('users.destroy');

//登录页
Route::get('/login', 'SessionsController@create')->name('login');
//登陆
Route::post('/login','SessionsController@store')->name('login');
//注销
Route::delete('/logout', 'SessionsController@destroy')->name('logout');

//邮件激活账户
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

//显示重置密码的邮箱发送页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//邮箱发送重设链接
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//执行密码更新操作
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
/*Route::get('/statuses', 'StatusesController@store')->name('status.store');
Route::post('/statuses/{status}', 'StatusesController@destroy')->name('status.delete');*/