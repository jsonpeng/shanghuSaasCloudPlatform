<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChargePackagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('套餐名称');
         
            $table->integer('level')->nullable()->default(1)->comment('会员等级值');
            $table->integer('canuse_shop_num')->nullable()->default(1)->comment('可以使用的店铺数量');
            $table->string('image')->nullable()->comment('套餐图片');
            $table->longtext('exclusive')->nullable()->comment('专享条目');
       
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
        Schema::drop('charge_packages');
    }
}
