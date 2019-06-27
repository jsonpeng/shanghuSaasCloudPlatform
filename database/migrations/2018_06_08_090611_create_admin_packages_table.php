<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminPackagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_packages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');

            $table->timestamp('package_endtime')->comment('到期时间');

            $table->string('package_name')->nullable()->comment('套餐名称');
            $table->integer('level')->nullable()->default(0)->comment('等级值');
            $table->integer('canuse_shop_num')->nullable()->default(1)->comment('可以使用的店铺数量');
            $table->float('price')->nullable()->default(0)->comment('套餐购买价格');

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
        Schema::drop('admin_packages');
    }
}
