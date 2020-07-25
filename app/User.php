<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Status;

class User extends Authenticatable
{
    use Notifiable;

    //指定数据库表
    protected $table = 'users';

    //$fillable 过滤用户提交的字段，只有包含在该属性中的字段才能够被正常更新
    protected $fillable = [
        'name', 'email', 'password',
    ];

    //$hidden 隐藏字段
    protected $hidden = [
        'password', 'remember_token',
    ];

    //$casts 在访问时将某列转为另一种类型，如下将users表格email_verified_at列的字段转为datetime
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function gravatar($size = '100'){
        //$this->attributes['email'] 获取到用户的邮箱；
        //使用 trim 方法剔除邮箱的前后空白内容；
        //用 strtolower 方法将邮箱转换为小写
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public static function boot(){

        //先执行父类的代码，后面执行自己重写的代码
        //parent::调用父类方法; 
        parent::boot();

        //监听，创建activation_token
        static::creating(function($user){
            $user->activation_token = Str::random(10);
        });
    }

    public function statuses(){
        return $this->hasMany(Status::class);
    }

    public function feed(){
        return $this->statuses()->orderBy('created_at', 'desc');
    }


}
