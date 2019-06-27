<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类名称');
            $table->string('slug')->nullable()->comment('分类别名');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('image')->nullable()->comment('图片');
            $table->enum('show', ['是','否'])->default('是')->comment('是否展示');
            $table->enum('status', [
                    '上线',
                    '下架'
                ])->default('上线')->comment('当前状态(上线 下架)');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            $table->index('sort');

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
        Schema::drop('categories');
    }
}
