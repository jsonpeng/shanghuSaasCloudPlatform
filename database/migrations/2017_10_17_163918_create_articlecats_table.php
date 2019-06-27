<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlecatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlecats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('分类名称');
            $table->string('slug')->default('')->comment('分类别名');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('image')->nullable()->default('')->comment('图像');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            $table->index(['id', 'created_at']);
            // $table->index('parent_id');
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
        Schema::drop('articlecats');
    }
}
