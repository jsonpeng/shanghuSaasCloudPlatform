<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponRulesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('0 新用户注册 1 购物满送 2 推荐新用户注册 3 推荐新用户下单 4 免费领取');
            $table->float('base')->default(0)->comment('购物满金额');
            $table->date('time_begin')->default('1970-01-01')->comment('有效期开始时间');
            $table->date('time_end')->default('1970-01-01')->comment('有效期结束时间');
            $table->integer('max_count')->default(0)->comment('最大发放次数');
            $table->integer('count')->default(0)->comment('已经发放次数');

            $table->string('account')->comment('租户');
            
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('time_begin');
            $table->index('time_end');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('coupon_rule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->integer('rule_id')->unsigned();
            $table->foreign('rule_id')->references('id')->on('rules');

            $table->index(['id', 'created_at']);

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
        Schema::drop('coupon_rule');
        Schema::drop('rules');
    }
}
