<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount')->comment('积分余额');
            $table->integer('change')->comment('积分变动，正为增加，负为支出');
            $table->string('detail')->nullable()->comment('详情');
            $table->tinyInteger('type')->default(0)->comment('0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->index(['id', 'created_at']);
            $table->index('user_id');

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
        Schema::drop('credit_logs');
    }
}
