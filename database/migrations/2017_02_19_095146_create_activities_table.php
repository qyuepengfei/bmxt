<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //报名活动
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('act_name', 60)->comment('活动名称');
            $table->timestamp('start_time')->comment('开始时间');
            $table->timestamp('end_time')->comment('结束时间');
            $table->tinyInteger('status')->comment('活动状态: 0.关闭 1.启用');
            $table->string('remark',1000)->comment('活动须知');
            $table->string('config', 2000)->comment('活动配置');
            $table->string('form_design', 8000)->comment('表单设计');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activities');
    }
}
