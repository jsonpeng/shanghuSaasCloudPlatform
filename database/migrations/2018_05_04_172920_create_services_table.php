<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->string('intro')->nullable()->comment('介绍');
            $table->enum('time_type', [0,1])->default(0)->comment('0 固定有效日期起始时间','1一段时间后');
            $table->integer('expire_days')->nullable()->comment('一段时间后多少天');
            $table->date('time_begin')->nullable()->default('2000-01-01')->comment('有效期开始时间');
            $table->date('time_end')->nullable()->default('2000-01-01')->comment('有效期结束时间');
            $table->float('commission')->comment('提成');
        
            $table->string('account')->comment('租户');
            $table->string('image',256)->nullable()->comment('服务图片');
            $table->integer('all_use')->nullable()->default(0)->comment('0不是全场通用1全场通用');
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
        Schema::drop('services');
    }
}
