<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditsServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('兑换标题');
            $table->string('image')->nullable()->comment('显示图像');
            $table->longtext('content')->nullable()->comment('详情');
            $table->enum('type',['礼物','服务'])->comment('兑换类型');
            $table->integer('service_id')->nullable()->comment('服务id');
            $table->integer('need_num')->comment('需要的积分数量');
            $table->integer('count_time')->nullable()->default(0)->comment('兑换次数(人气)');

            $table->string('account')->comment('租户');
            
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('service_id');
            
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
        Schema::drop('credits_services');
    }
}
