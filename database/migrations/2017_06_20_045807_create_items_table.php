<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('商品名称');
            $table->string('pic')->nullable()->comment('商品图片');
            $table->float('price')->default(0)->comment('商品价格');

            $table->float('cost')->nullable()->default(0)->comment('成本价格');
            $table->float('count')->nullable()->default(0)->comment('商品数量');
            $table->string('unit')->nullable()->default('')->comment('规格单元');

            $table->integer('order_id')->comment('订单编号');
            $table->integer('product_id')->comment('产品编号');
            $table->string('spec_key')->nullable()->comment('商品名称');
            $table->string('spec_keyname')->nullable()->comment('商品名称');

            $table->index(['id', 'created_at']);
            $table->index('order_id');
            $table->index('product_id');

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
        Schema::drop('items');
    }
}
