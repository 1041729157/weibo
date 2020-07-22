<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//User::class 指定模型类
        $users = factory(User::class)->times(500)->make();

        //makeVisible 方法临时显示 User 模型里指定的隐藏属性 $hidden
        //insert 方法来将生成假用户列表数据批量插入到数据库中
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'HH';
        $user->email = '1041729157@qq.com';
        $user->password = bcrypt('123456');
        $user->is_admin = true;//不能加引号
        $user->save();
    }
}
