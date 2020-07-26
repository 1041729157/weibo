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


    //user_id 和 follower_id 都是 user 的主键 ID，只是在逻辑上，user_id 表示被关注人，follower_id 表示被关注人的粉丝，followers 表作为中间表存储了这个关系，它的两个关联表恰好是同一个表，即 user 表
    public function followers(){
        return $this->belongsTomany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function followings(){
        //第二个参数自定义关联关系表名称，第三个参数是定义在关联中的模型外键名，而第四个参数则是要合并的模型外键名
        return $this->belongsTomany(User::class, 'followers', 'follower_id', 'user_id');
    }

    //关注
    public function follow($user_ids){
        if ( ! is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        //$user->followings()获取用户关注人列表
        $this->followings()->sync($user_ids, false);
    }

    //取消关注
    public function unfollow($user_ids){
        if ( ! is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    public function isFollowing($user_id){
        //$user->followings 同等于 $user->followings()->get() 返回的是一个 Collection 类的实例，contains 方法是 Collection 类的一个方法
        //$user->followings() 返回的是关联对象
        return $this->followings->contains($user_id);
    }


}
