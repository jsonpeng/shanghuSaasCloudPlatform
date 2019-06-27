<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->string('nickname'); 
            $table->string('mobile')->unique(); 
            $table->string('password'); 
            $table->enum('type', ['管理员', '代理商', '商户'])->default('商户');
            $table->integer('parent_id')->nullable()->unsigned()->comment('推荐人');
            $table->integer('active')->default(1)->comment('账户状态');
            $table->integer('member')->default(0)->comment('是否会员');
            $table->timestamp('member_end')->nullable()->comment('会员到期日期');
            $table->integer('shop_type')->nullable()->default(0)->comment('0 对应店铺的店铺管理员 1 总店管理员'); 
            $table->float('use_money')->nullable()->default(0)->comment('余额'); 
            $table->string('account')->nullable()->comment('租户, 商户才有');

            $table->index(['id', 'created_at']);

            $table->rememberToken(); 
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
        Schema::drop('admins');
    }
}
