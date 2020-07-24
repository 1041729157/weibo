<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{

    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            //increments的数字上限很大很大，bigIncrements的数字上限比increments更大(自增序列)
            // $table->bigIncrements('id');
            $table->increments('id');
            $table->text('content');
            $table->integer('user_id')->index();
            $table->index(['created_at']);
            $table->timestamps();//timestamps 方法会为微博数据表生成一个微博创建时间字段 created_at 和一个微博更新时间字段 updated_at，不需要再手动创建
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
