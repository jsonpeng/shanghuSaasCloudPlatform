<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamFoundsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_founds', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('time_begin')->nullable()->comment('开团时间');
            $table->timestamp('time_end')->nullable()->comment('结束时间');
            $table->string('nickname')->nullable()->comment('用户昵称');
            $table->string('head_pic')->nullable()->comment('用户头像');
            $table->integer('join_num')->comment('已拼人数');
            $table->integer('need_mem')->comment('成团人数');
            $table->decimal('price', 10, 2)->comment('拼团价格');
            $table->decimal('origin_price', 10, 2)->nullable()->comment('原本价格');
            $table->integer('status')->default(0)->comment('拼团状态0:待开团(表示已下单但是未支付)1:已经开团(团长已支付)2:拼团成功,3拼团失败');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('team_sales');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->index(['id', 'created_at']);
            $table->index('user_id');
            $table->index('team_id');
            $table->index('order_id');

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
        Schema::drop('team_founds');
    }
}
