<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChargePackagesPricesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_packages_prices', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('charge_packages');

            $table->float('years')->nullalbe()->default(1)->comment('套餐年数');

            $table->float('price')->nullalbe()->default(0)->comment('组合购买价格');
            $table->float('origin_price')->nullable()->default(0)->comment('原价');
            $table->integer('bonus_one')->nullable()->default(0)->comment('一级代理商分佣');
            $table->integer('bonus_two')->nullable()->default(0)->comment('二级代理商分佣');

            $table->index(['id', 'created_at']);
            $table->index('package_id');
            
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
        Schema::drop('charge_packages_prices');
    }
}
