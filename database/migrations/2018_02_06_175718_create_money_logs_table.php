<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMoneyLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('amount')->comment('余额');
            $table->float('change')->comment('余额变动记录');
            $table->string('detail')->nullable()->comment('详情');
             $table->tinyInteger('type')->default(0)->comment('0系统赠送，1分佣 2消费');
            
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
        Schema::drop('money_logs');
    }
}
