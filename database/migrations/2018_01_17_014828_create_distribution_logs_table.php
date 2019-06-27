<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDistributionLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_user_id')->comment('订单用户');
            $table->integer('user_id')->comment('分佣用户');
            $table->decimal('commission', 10, 2)->comment('佣金');
            $table->decimal('order_money', 10, 2)->comment('订单金额');
            $table->integer('user_dis_level')->comment('分佣用户层级');
            $table->string('status')->comment('佣金发放状态 待发放 已发放 订单作废');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->index(['id', 'created_at']);
            $table->index('user_id');
            $table->index('order_id');

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
        Schema::drop('distribution_logs');
    }
}
