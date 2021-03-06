<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchbjDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 比赛
        Schema::create('competitons', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->comments('比赛名称');
            $table->string('remark', 1500)->comments('比赛介绍');
        });


        // 比赛项目
        Schema::create('competition_events', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('event_group')->comments('赛项分组');
            $table->integer('parent_id')->comments('上级类别ID');
            $table->string('name', 300)->comments('名称');
            $table->string('description', 1500)->comments('描述');
        });

        // 队伍
        Schema::create('competition_teams' , function(Blueprint $table){
            $table->increments('id');


            $table->string('invitecode', 50)->comments('邀请码');

            $table->string('team_no', 50)->comments('队伍编码');
            $table->string('team_name', 100)->comments('队伍名称');
            $table->unsignedInteger('competition_event_id')->comments('比赛项目');

            // 联系人
            $table->string('contact_name', 50)->comments('联系人姓名');
            $table->string('contact_mobile', 50)->comments('联系电话');
            $table->string('contact_email', 100)->comments('联系人邮箱');
            $table->string('contact_remark', 1500)->comments('备注');

            // 发票
            $table->string('invoice_title', 500)->comments('开票抬头');
            $table->string('invoice_code', 100)->comments('统一社会信用代码');
            $table->string('invoice_money', 100)->comments('开票金额（单位：元）');
            $table->string('invoice_type', 100)->comments('发票明细');
            $table->string('invoice_mail_address', 1000)->comments('收件地址');
            $table->string('invoice_mail_recipients', 50)->comments('收件人姓名');
            $table->string('invoice_mail_mobile', 50)->comments('收件人联系电话');
            $table->string('invoice_mail_email', 100)->comments('收件人邮箱');
            $table->string('invoice_remark', 1500)->comments('发票邮寄备注');


            $table->timestamps();

            $table->unique('team_no');
            // $table->foreign('competition_event_id')->references('id')->on('competition_events');

        });

        Schema::create('competition_team_members', function(Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('team_id')->comments('队伍id'); //
            $table->string('type', 20)->comments('成员类型: 领队,指导教师,队长,队员');

            // 基本信息
            $table->string('name', 100)->comments('名字');
            $table->string('mobile', 50)->comments('手机号码');
            $table->string('email', 300)->comments('邮箱');
            $table->string('idcard_type', 50)->comments('证件类型: 身份证,护照');
            $table->string('idcard_no', 300)->comments('证件号码:');
            $table->string('nation', 100)->comments('民族');
            $table->string('sex', 30)->comments('性别');
            $table->string('birthday', 100)->comments('生日');         // 年龄生日二选一，默认生日
            $table->tinyInteger('age')->unsigned()->comments('年龄'); // 可选
            $table->mediumInteger('height')->comments('身高:cm');
            $table->string('photo_url', 1000)->comments('照片地址');

            //其他资料
            $table->string('vocation', 300)->comments('职业');
            $table->string('work_unit', 300)->comments('工作单位');
            $table->string('register_address', 300)->comments('户籍地址');
            $table->string('home_address', 300)->comments('现居详情');

            $table->string('remark', 1500)->comments('备注');
            $table->string('profiles', 2000)->comments('其他资料');

            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('team_id')->references('id')->on('competition_teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        // \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('competition_team_members');
        Schema::drop('competition_teams');
        Schema::drop('competition_events');
        Schema::drop('competitons');
        // \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
