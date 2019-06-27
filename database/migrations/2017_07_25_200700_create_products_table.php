<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateProductsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('产品名称');
            $table->string('sn')->nullable()->comment('产品编号');
            $table->string('image',256)->nullable()->comment('产品图片');
            $table->float('price')->comment('产品价格');
            $table->float('market_price')->default(0)->comment('市场价格');

            $table->integer('max_buy')->default(100)->comment('单次最大可买数量');
            
            $table->string('remark')->nullable()->comment('附加说明：活动促销信息等用，高亮显示在价格下方');
            $table->longText('intro')->nullable()->comment('产品介绍');

            $table->tinyInteger('shelf')->default(0)->comment('是否上架 0 否 1 是');
            
            $table->integer('sort')->nullable()->default(0)->comment('展示排序');
            $table->tinyInteger('is_new')->default(0)->comment('0非新品 1新品');
            $table->tinyInteger('is_hot')->default(0)->comment('0非热卖 1热卖');
            $table->integer('views')->default(1)->comment('浏览量');
            $table->integer('collectoins')->default(1)->comment('收藏量');
            $table->integer('sales_count')->default(1)->comment('销售量');

            $table->tinyInteger('prom_type')->default(0)->comment('0无1抢购2团购3商品促销4订单促销5拼团');
            $table->integer('prom_id')->default(0)->comment('优惠活动ID');
            $table->float('commission')->default(0)->comment('佣金用于提成');

            $table->integer('category_id')->nullable()->unsigned();


            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('prom_id');
            // $table->index('brand_id');
            // $table->index('type_id');
            $table->index('category_id');
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
        Schema::drop('products');
    }
}
