<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankCardsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('银行名称');
            $table->integer('type')->comment('银行卡类型0储蓄卡1信用卡');
            $table->string('bank_name')->comment('支行');
            $table->string('user_name')->comment('用户名');
            $table->string('count')->comment('账号');
            $table->string('mobile')->nullable()->comment('短信提醒手机号');
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->index('id');
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
        Schema::drop('bank_cards');
    }
}
