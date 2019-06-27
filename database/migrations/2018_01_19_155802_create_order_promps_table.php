<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderPrompsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_promps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('活动名称');
            $table->integer('type')->comment('0 打折优惠 1减价优惠');
            $table->decimal('base', 10, 2)->comment('需满足的价格');
            $table->decimal('value', 10, 2)->comment('优惠数值 打折就是折扣， 减价就是减价金额 固定金额就是出售价格');
            $table->timestamp('time_begin')->nullable()->comment('活动开始时间');
            $table->timestamp('time_end')->nullable()->comment('活动结束时间');
            $table->string('image')->nullable()->comment('活动宣传图片');
            $table->longtext('intro')->nullable()->comment('活动介绍');

            $table->string('account')->comment('租户');
            
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

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
        Schema::drop('order_promps');
    }
}
