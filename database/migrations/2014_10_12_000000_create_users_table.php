<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('名称');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('password', 60)->nullable();
            $table->string('password-pay', 60)->nullable()->comment('支付密码');
            $table->enum('sex', ['女','男'])->default('男')->comment('性别');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('head_image')->nullable()->comment('用户头像');
            $table->string('mobile')->nullable()->comment('手机');
            $table->string('qq')->nullable()->comment('QQ');
            $table->string('openid')->nullable()->comment('微信OPEN ID');
            $table->string('unionid')->nullable()->comment('公众平台ID');
            $table->string('code')->nullable()->comment('推荐码');
            $table->string('share_qcode')->nullable()->comment('推荐二维码');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态0正常 1冻结');
            $table->integer('credits')->default(0)->comment('用户积分');
            $table->float('user_money')->default(0)->comment('用户金额');
            $table->float('distribut_money')->default(0)->comment('累积分佣金额');
            $table->float('consume_total')->default(0)->comment('累计消费额度');

            $table->timestamp('last_login')->nullable()->comment('最后登录日期');
            $table->string('last_ip')->nullable()->comment('最后登录IP');
            $table->string('oauth')->nullable()->comment('第三方来源');

            $table->string('province')->nullable()->default('')->comment('省');
            $table->string('city')->nullable()->default('')->comment('市');
            $table->string('district')->nullable()->default('')->comment('区');

            $table->tinyInteger('lock')->nullable()->default(0)->comment('冻结用户 0 否 1 是');
            $table->tinyInteger('is_distribute')->nullable()->default(0)->comment('是否分销商 0 否 1 是');

            $table->integer('leader1')->unsigned()->nullable()->default(0)->comment('一级推荐人');
            $table->integer('leader2')->unsigned()->nullable()->default(0)->comment('二级推荐人');
            $table->integer('leader3')->unsigned()->nullable()->default(0)->comment('三级推荐人');

            $table->integer('level1')->unsigned()->default(0)->comment('一级下线数');
            $table->integer('level2')->unsigned()->default(0)->comment('二级下线数');
            $table->integer('level3')->unsigned()->default(0)->comment('三级下线数');

            //会员等级
            $table->integer('user_level')->unsigned();

            $table->string('account')->comment('租户');
            $table->integer('growth')->nullable()->default(0)->comment('成长值');
            $table->enum('type',['用户','业务员','管理员'])->default('用户')->comment('用户身份');

            $table->index(['id', 'created_at']);
            $table->index('user_level');

            $table->rememberToken();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
