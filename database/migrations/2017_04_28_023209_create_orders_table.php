<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //订单表
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('snumber')->comment('商户订单号');
            $table->float('price')->default(0)->comment('价格');
            $table->float('cost')->default(0)->comment('成本');
            $table->float('origin_price')->default(0)->comment('原价');
            $table->float('preferential')->default(0)->comment('订单促销优惠金额');
            $table->float('coupon_money')->default(0)->comment('优惠券优惠金额');
            $table->integer('credits')->default(0)->comment('使用积分');
            $table->float('credits_money')->default(0)->comment('使用积分抵扣金额');
            $table->float('user_level_money')->default(0)->comment('会员等级折扣');
            $table->float('user_money_pay')->default(0)->comment('用户余额支付');
            $table->decimal('price_adjust', 10, 2)->default(0)->comment('调整价格');
            $table->float('freight')->default(0)->comment('运费');

            $table->timestamp('sendtime')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('发货时间');
            $table->timestamp('confirm_time')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('确认时间');
            $table->timestamp('paytime')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('支付时间');

            $table->string('pay_type')->default('在线支付', '货到付款')->comment('支付方式');
            $table->enum('pay_platform', ['微信支付', '支付宝', '微信(PAYSAPI)', '管理员操作'])->default('微信支付')->comment('支付平台');
            $table->enum('order_pay', ['未支付','已支付'])->default('未支付');
            $table->string('pay_no')->default('')->comment('平台订单号');
            $table->string('out_trade_no')->default('')->comment('商户订单号');

            $table->enum('order_status', ['未确认','已确认', '无效', '已取消'])->default('未确认');
            $table->enum('order_delivery', ['未发货','已发货','已收货','退换货'])->default('未发货');
            

            $table->enum('invoice', ['要','不要'])->default('不要')->comment('要不要发票');
            $table->enum('invoice_type', ['','个人','公司'])->nullable()->default('')->comment('发票对象');
            $table->string('invoice_title')->nullable()->default('')->comment('发票抬头');
            $table->string('tax_no')->nullable()->default('')->comment('税号');

            $table->string('delivery_company')->default('')->nullable()->comment('快递公司');
            $table->string('delivery_return')->default('')->nullable()->comment('回寄快递单号');
            $table->string('delivery_no')->default('')->nullable()->comment('快递单号');

            $table->string('remark', 255)->default('')->nullable()->comment('用户留言');

            $table->integer('prom_id')->nullable()->comment('促销ID');
            $table->integer('prom_type')->nullable()->comment('促销类型');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('customer_name')->default('')->comment('收货人姓名');
            $table->string('customer_phone')->default('')->comment('收货人电话');
            $table->string('customer_address')->nullable()->default('')->comment('收货人地址');

            $table->integer('delivery_province')->nullable()->default(0)->unsigned();
            $table->integer('delivery_city')->nullable()->default(0)->unsigned();
            $table->integer('delivery_district')->nullable()->default(0)->unsigned();
            $table->integer('delivery_street')->nullable()->default(0)->unsigned();
            $table->string('backup01')->default('')->comment('管理员备注信息');
            $table->string('backup02')->default('')->comment('备用');
            $table->string('backup03')->default('')->comment('备用');
            $table->string('backup04')->default('')->comment('备用');
            $table->string('backup05')->default('')->comment('备用');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');
            
            $table->index(['id', 'created_at']);
            $table->index('prom_id');
            $table->index('user_id');

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
        
        Schema::drop('orders');
    }
}
