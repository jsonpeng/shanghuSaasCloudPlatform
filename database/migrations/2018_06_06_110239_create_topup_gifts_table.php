<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopupGiftsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_gifts', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price')->comment('充值金额');
            $table->float('give_balance')->nullable()->default(0)->comment('赠送余额');
            $table->integer('give_credits')->nullable()->default(0)->comment('赠送积分');
            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            
            $table->index('account');
            $table->index('shop_id');

            $table->integer('coupon_id')->nullable()->comment('赠送优惠券id');

            $table->index(['id', 'created_at']);
            $table->index('coupon_id');

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
        Schema::drop('topup_gifts');
    }
}
