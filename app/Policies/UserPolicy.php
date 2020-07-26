<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    //update 方法接收两个参数，第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例
    public function update(User $currentUser, User $user){
        return $currentUser->id === $user->id;
    }

    public function destroy(User $c, User $user){
    	return $c->is_admin && $c->id !== $user->id;
    }

    public function follow(User $c, User $user){
    	return $c->id !== $user->id;
    }
}
