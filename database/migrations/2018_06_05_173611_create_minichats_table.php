<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMinichatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('minichats', function (Blueprint $table) {
            $table->increments('id');

            $table->string('app_id')->comment('小程序ID');
            $table->string('access_token')->nullable()->comment('access_token');
            $table->timestamp('expires')->nullable()->comment('token过期时间');
            $table->string('refresh_token')->nullable()->comment('refresh_token');

            $table->string('nick_name')->nullable()->comment('授权方昵称');
            $table->string('head_img')->nullable()->comment('授权方头像');
            $table->string('service_type_info')->nullable()->comment('默认为0');
            $table->string('verify_type_info')->nullable()->comment('授权方认证类型，-1代表未认证，0代表微信认证');
            $table->string('user_name')->nullable()->comment('小程序的原始ID');
            $table->string('principal_name')->nullable()->comment('小程序的主体名称');
            $table->string('qrcode_url')->nullable()->comment('二维码图片的URL');
            $table->string('signature')->nullable()->comment('帐号介绍');
            $table->string('business_info_store')->nullable()->comment('是否开通微信门店功能');
            $table->string('business_info_scan')->nullable()->comment('是否开通微信扫商品功能');
            $table->string('business_info_pay')->nullable()->comment('是否开通微信支付功能');
            $table->string('business_info_card')->nullable()->comment('是否开通微信卡券功能');
            $table->string('business_info_shake')->nullable()->comment('是否开通微信摇一摇功能');

            $table->integer('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');

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
        Schema::drop('minichats');
    }
}
