<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlashSalesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->increments('id');
            //$table->string('name')->comment('促销活动名称');
            $table->float('price')->comment('销售价格');
            $table->float('origin_price')->nullable()->comment('商品原价');
            $table->integer('product_num')->comment('参加活动商品数');
            $table->integer('buy_limit')->comment('每人限购数量');
            $table->integer('buy_num')->nullable()->default(0)->comment('已出售数量');
            $table->integer('order_num')->nullable()->default(0)->comment('订单数量');
            $table->longtext('intro')->nullable()->comment('活动介绍');
            $table->timestamp('time_begin')->nullable()->comment('活动开始时间');
            $table->timestamp('time_end')->nullable()->comment('活动结束时间');
            $table->tinyInteger('is_end')->nullable()->default(0)->comment('活动是否结束');
            $table->string('product_name')->nullable()->comment('产品名称');
            $table->string('image')->nullable()->comment('产品图片');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            // $table->integer('spec_id')->unsigned();
            //$table->foreign('spec_id')->references('id')->on('spec_product_prices');

            $table->index(['id', 'created_at']);
            $table->index('product_id');
            // $table->index('spec_id');

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
        Schema::drop('flash_sales');
    }
}
