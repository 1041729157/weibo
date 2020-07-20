<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{

    public function run()
    {

    	// Model::unguard();

    	//call 方法指定我们要运行假数据填充的文件
        $this->call(UsersTableSeeder::class);

        // Model::reguard();
    }
}
