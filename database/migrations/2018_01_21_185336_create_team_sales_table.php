<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamSalesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('活动名称');
            // $table->tinyInteger('type')->comment('类型 0分享团 1佣金团 2抽奖团');
           // $table->integer('expire_hour')->comment('开团后过期时间 单位小时');
            $table->date('time_begin')->nullable()->default('2000-01-01')->comment('活动开始时间');
            $table->date('time_end')->nullable()->default('2000-01-01')->comment('活动结束时间');
            $table->float('price')->comment('销售价格');
            $table->integer('member')->comment('成团人数');
            $table->string('product_name')->comment('商品名称');
            $table->float('bonus')->nullable()->default(0)->comment('团长佣金');
            // $table->integer('lottery_count')->nullable()->default(1)->comment('中奖人数');
            $table->integer('buy_limit')->default(1)->comment('限购数量');
            $table->integer('sales_sum')->nullable()->default(0)->comment('已拼数量');
            $table->integer('sales_sum_base')->nullable()->default(0)->comment('已拼数量虚假基数');
            $table->integer('sort')->nullable()->default(50)->comment('排序');
            $table->string('share_title')->nullable()->default('')->comment('分享标题');
            $table->string('share_des')->nullable()->default('')->comment('分享描述');
            $table->string('share_img')->nullable()->default('')->comment('分享图片');
            $table->tinyInteger('shelf')->nullable()->default(1)->comment('上架 0不上架 1上架');
            $table->float('origin_price')->nullable()->comment('商品原价');

            // $table->integer('spec_id')->nullable()->default(0)->unsigned();
            //$table->foreign('spec_id')->references('id')->on('spec_product_prices');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('product_id');
            // $table->index('spec_id');
            $table->index('sort');

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
        Schema::drop('team_sales');
    }
}
