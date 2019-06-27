<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
           $table->increments('id');
            $table->string('name')->default('')->comment('文章标题');
            // $table->string('slug')->default('')->comment('别名');
            //$table->string('image')->nullable()->default('')->comment('封面图片');
            //$table->string('image2')->nullable()->default('')->comment('备用图片');
            //$table->string('brief')->nullable()->default('')->comment('简介');
            //$table->string('type')->nullable()->default('post')->comment('类型');
            //$table->longtext('more')->nullable()->comment('更多');
            $table->longtext('content')->nullable()->comment('正文');
            $table->integer('view')->default(1)->comment('浏览量');
            $table->integer('sort')->default(0)->comment('排序');



            $table->string('seo_title')->nullable()->default('')->comment('SEO_标题');
            $table->string('seo_des')->nullable()->default('')->comment('SEO_描述');
            $table->string('seo_keyword')->nullable()->default('')->comment('SEO_关键词');
            $table->tinyInteger('status')->nullable()->default(0)->comment('文章状态 0 草稿 1 发布');

            //发布人
            $table->integer('user_id')->nullable()->default(0)->comment('发布用户id');

            //热门
            $table->tinyInteger('is_hot')->nullable()->default(0)->comment('是否热门 0 不是热门 1 热门');
            
            $table->integer('is_admin')->nullable()->default(1)->comment('是否是管理员 1是管理员 0是用户');

            $table->string('account')->comment('租户');

            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

            //$table->foreign('user_id')->references('id')->on('users');
            // $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')->references('id')->on('users');

            $table->index(['id', 'created_at']);
            $table->index('user_id');

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::create('articlecats_post', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('articlecats');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');

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
        Schema::drop('articlecats_post');
        Schema::drop('posts');
    }
}
