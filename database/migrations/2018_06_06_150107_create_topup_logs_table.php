<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopupLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price')->comment('充值金额');

            $table->integer('topup_id')->nullable()->comment('充值服务id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('topup_id');
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
        Schema::drop('topup_logs');
    }
}
