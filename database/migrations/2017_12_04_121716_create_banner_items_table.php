<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerItemsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->comment('图片');
            $table->string('link')->nullable()->comment('跳转链接');
            $table->integer('sort')->nullable()->comment('排序');

            $table->integer('banner_id')->unsigned();
            $table->foreign('banner_id')->references('id')->on('banners');

            $table->index(['id', 'created_at']);
            $table->index('banner_id');
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
        Schema::drop('banner_items');
    }
}
