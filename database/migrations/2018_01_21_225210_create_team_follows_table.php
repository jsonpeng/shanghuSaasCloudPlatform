<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamFollowsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_follows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname')->nullable()->comment('用户昵称');
            $table->string('head_pic')->nullable()->comment('用户头像');
            $table->tinyInteger('status')->default(0)->comment('参团状态0:待拼单(表示已下单但是未支付)1拼单成功(已支付)2成团成功3成团失败');
            $table->tinyInteger('is_winner')->default(0)->comment('是否中奖');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('found_id')->unsigned();
            $table->foreign('found_id')->references('id')->on('team_founds');
            $table->integer('found_user_id')->unsigned();
            $table->foreign('found_user_id')->references('id')->on('users');
            $table->integer('team_id')->unsigned();
            $table->foreign('team_id')->references('id')->on('team_sales');

            $table->index(['id', 'created_at']);
            $table->index('user_id');
            $table->index('team_id');
            $table->index('found_user_id');
            $table->index('found_id');
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
        Schema::drop('team_follows');
    }
}
