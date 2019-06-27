<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_users', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('coupon_type')->nullable()->comment('优惠券类型');
            $table->integer('order_id')->nullable()->comment('使用的订单好');
            $table->string('from_way')->nullable()->comment('优惠券来源');
            $table->timestamp('use_time')->nullable()->comment('使用时间');
            $table->timestamp('time_begin')->nullable()->comment('有效期起始时间');
            $table->timestamp('time_end')->nullable()->comment('有效期终止时间');
            $table->string('code')->nullable()->comment('兑换码，暂不用');
            $table->tinyInteger('status')->default(0)->comment('优惠券状态 0未使用 1冻结 2已使用 3过期 4作废');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');

            $table->index('shop_id');
            $table->index(['id', 'created_at']);
            $table->index('order_id');
            $table->index('user_id');
            $table->index('coupon_id');

            $table->timestamps();
            //$table->softDeletes();
        });

        //订单和优惠券
        Schema::create('coupon_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupon_users');
            $table->integer('order2_id')->unsigned();
            $table->foreign('order2_id')->references('id')->on('orders');

            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupon_order');
        Schema::drop('coupon_users');
    }
}