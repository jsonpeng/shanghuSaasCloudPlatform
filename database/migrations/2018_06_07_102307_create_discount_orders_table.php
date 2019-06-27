<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscountOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price')->comment('优惠订单实际金额');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->float('orgin_price')->comment('原价');
            $table->float('no_discount_price')->nullable()->default(0)->comment('不参与优惠价格');
            $table->float('use_user_money')->nullable()->default(0)->comment('使用余额');
            $table->float('user_level_money')->nullable()->default(0)->comment('会员等级优惠金额');

            $table->integer('coupon_id')->nullable()->comment('使用优惠券id');
            $table->float('coupon_price')->nullable()->default(0)->comment('优惠券优惠金额');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('coupon_id');
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
        Schema::drop('discount_orders');
    }
}
