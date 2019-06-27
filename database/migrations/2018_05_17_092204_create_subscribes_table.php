<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscribesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subman')->comment('预约人名称');
            $table->string('mobile')->comment('预约人手机号');
            $table->string('arrive_time')->comment('到店时间');
            $table->string('remark')->nullable()->comment('备注');
            $table->string('account')->comment('租户');
            $table->enum('status', ['待分配','待服务','已完成','已超时','已取消'])->default('待分配')->comment('预约状态');
            $table->integer('user_id')->nullable()->unsigned();
            // $table->foreign('user_id')->references('id')->on('users');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');

            $table->integer('technician_id')->unsigned();
            $table->foreign('technician_id')->references('id')->on('technicians');

            $table->index(['id', 'created_at']);
            $table->index('shop_id');
            $table->index('service_id');
            $table->index('technician_id');

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
        Schema::drop('subscribes');
    }
}
