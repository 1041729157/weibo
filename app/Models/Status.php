<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Status extends Model
{
    protected $table = 'statuses';

    //允许content字段更新
    protected $fillable = ['content'];

    public function user(){
    	//hasOne 正向关联，belongsTo 反向关联，也就是我有一个手机，手机属于我
    	return $this->belongsTo(User::class);
    }
}
