<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStoreShopsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('店铺名称');
            $table->string('address')->comment('店铺地址');
            $table->float('jindu')->nullable()->comment('经度');
            $table->float('weidu')->nullable()->comment('纬度');
            $table->string('tel')->comment('客服电话');
            $table->string('logo')->nullable()->comment('店铺logo');
            $table->string('account')->comment('租户');
            $table->string('contact_man')->nullable()->comment('店铺联系人');
            $table->string('weixin')->nullable()->comment('店铺微信');

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
        Schema::drop('store_shops');
    }
}
