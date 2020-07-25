<?php

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\User;

class StatusesTableSeeder extends Seeder
{

    public function run()
    {
        $user_ids = ['1', '2', '3'];
        $faker = app(Faker\Generator::class);

        //each() 函数返回当前元素的键名和键值，并将内部指针向前移动
        $statuses = factory(Status::class)->times(100)->make()->each(function ($statu) use ($faker, $user_ids) {
        	$statu->user_id = $faker->randomElement($user_ids);
        });

        Status::insert($statuses->toArray());
    }
}
