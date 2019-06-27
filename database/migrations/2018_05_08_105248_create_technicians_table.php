
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTechniciansTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('技师名称');
            $table->string('image')->nullable()->comment('数量');
            $table->longText('intro')->nullable()->comment('技师介绍');
            $table->string('workday')->comment('工作时间');
            $table->string('account')->comment('租户');
            

            $table->string('job')->nullable()->default('技师')->comment('职位');
            $table->integer('sentiment')->nullable()->default(0)->comment('人气数');
            $table->integer('give_like')->nullable()->default(0)->comment('点赞数');
            $table->integer('forward')->nullable()->default(0)->comment('转发数');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('weixin')->nullable()->comment('微信');

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
        Schema::drop('technicians');
    }
}
