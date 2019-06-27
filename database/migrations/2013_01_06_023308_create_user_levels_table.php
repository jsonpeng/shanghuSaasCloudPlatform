<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserLevelsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('用户等级名称');
            $table->integer('growth')->comment('需要成长值');
            // $table->integer('amount')->default(0)->comment('赠送金额');
            $table->integer('discount')->default(100)->comment('购物享受折扣');
            // $table->integer('days')->default(0)->comment('有效期天数，0表示永久有效');
            $table->string('discribe')->nullable()->default('')->comment('描述');
            $table->string('custom_benefits')->nullable()->comment('自定义权益');

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
        Schema::drop('user_levels');
    }
}
