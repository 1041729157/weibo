<?php

Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');

Route::get('/signup','UsersController@create')->name('signup');

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
Route::get('/users/{user}/edit','UsersController@edit')->name('usesr.edit');
//更新用户：
Route::patch('/users/{user}','UsersController@update')->name('users.update');
//删除用户：
Route::delete('/users/{user}','UsersController@destroy')->name('users.destroy');


Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login','SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');