<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackageLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('package_name')->comment('购买套餐名称');
            $table->float('price')->comment('购买套餐金额');

            $table->float('bonus_one')->nullable()->comment('一级佣金');
            $table->float('bonus_two')->nullable()->comment('二级佣金');

            $table->string('distribution_one')->nullable()->comment('一级分佣人');
            $table->string('distribution_two')->nullable()->comment('二级分佣人');

            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');

            $table->string('type')->nullable()->default('购买')->comment('购买套餐类型 购买/升级/续费');
            $table->integer('years')->nullable()->comment('购买多少年');
            $table->string('status')->nullable()->default('未支付')->comment('未支付/已完成');

            $table->index(['id', 'created_at']);
            $table->index('admin_id');

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
        Schema::drop('package_logs');
    }
}
