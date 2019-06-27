<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditServiceUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_service_users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('snumber')->comment('订单编号');

            $table->integer('credit_service_id')->unsigned();
            $table->foreign('credit_service_id')->references('id')->on('credits_services');
      
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('status',['待使用','已过期','待提货','已自提','已完成'])->comment('当前状态');

            $table->timestamp('pick_time')->nullable()->comment('使用时间');

            $table->integer('pick_shop_id')->nullable()->comment('使用/自提 店铺id');

            $table->index(['id', 'created_at']);
            $table->index('credit_service_id');
            $table->index('user_id');

            $table->string('account')->comment('租户');
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            
            $table->index('account');
            $table->index('shop_id');

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
        Schema::drop('credit_service_users');
    }
}
