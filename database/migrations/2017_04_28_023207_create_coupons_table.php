<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->integer('max_count')->default(0)->comment('每人最多领取数量');
            $table->tinyInteger('time_type')->default(0)->comment('0 固定有效日期','1 领券后一段时间内');
            $table->integer('expire_days')->default(30)->comment('领券后有效期');

            $table->date('time_begin')->default('2000-01-01')->comment('有效期开始时间');
            $table->date('time_end')->default('2000-01-01')->comment('有效期结束时间');
            $table->enum('type', ['满减','打折'])->default('满减')->comment('优惠券类型');
            $table->float('base')->default(0)->comment('满足最小金额');
            $table->float('given')->default(0)->comment('优惠金额');
            $table->float('discount')->default(100)->comment('折扣，九折就输入90，不打折就输入100');
            $table->enum('together', ['是','否'])->default('否')->comment('叠加使用');
            $table->string('department')->default('总部')->comment('买单部门');
            $table->string('remark')->default('')->comment('说明');

            $table->tinyInteger('range')->default(0)->comment('0全场通用 1指定分类 2指定商品');
            $table->integer('category_id')->default(0)->comment('适用分类');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');
            
            $table->index(['id', 'created_at']);
            $table->index('time_begin');
            $table->index('time_end');
            $table->index('category_id');



            $table->timestamps();
            $table->softDeletes();
        });

        /*
        Schema::create('coupon_shop', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coupon_id')->unsigned();
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shops');
            
            $table->timestamps();
            $table->softDeletes();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('coupon_shop');
        Schema::drop('coupons');
    }
}
