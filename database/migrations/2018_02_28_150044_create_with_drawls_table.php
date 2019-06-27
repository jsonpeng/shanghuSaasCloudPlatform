<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWithDrawlsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('with_drawls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->nullable()->comment('单号');
            $table->string('type')->nullable()->comment('交易方式(充值|提现|交易)');
            $table->float('price')->nullable()->comment('交易价格');
            $table->string('status')->nullable()->comment('交易状态(发起|处理中|已完成|撤回)');
            $table->string('arrive_time')->nullable()->comment('预计到账时间');
            $table->float('account_tem')->nullable()->comment('临时余额');
            $table->string('card_name')->nullable()->comment('银行卡名称');
            $table->string('card_no')->nullable()->comment('银行卡号');

            $table->integer('bank_id')->nullable()->unsigned(); //->comment('到账银行id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->index(['id', 'created_at']);
            $table->index('bank_id');

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
        Schema::drop('with_drawls');
    }
}
