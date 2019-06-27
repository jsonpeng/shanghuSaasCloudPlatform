<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('num')->nullable()->default(1)->comment('服务次数');

            $table->timestamp('time_begin')->nullable()->default('2000-01-01')->comment('有效期开始时间');
            $table->timestamp('time_end')->nullable()->default('2000-01-01')->comment('有效期结束时间');

            $table->enum('status', ['待使用','已使用','已过期'])->default('待使用')->comment('使用状态');

            $table->timestamp('use_time')->nullable()->comment('使用时间');
            $table->string('use_shop')->nullable()->comment('使用店铺');

            $table->index(['id', 'created_at']);
            $table->index('service_id');
            $table->index('user_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_users');
    }
}
