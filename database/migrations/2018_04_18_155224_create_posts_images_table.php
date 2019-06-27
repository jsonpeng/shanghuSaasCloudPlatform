<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       if(!Schema::hasTable('posts_images')) {
           Schema::create('posts_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');

            $table->index(['id', 'created_at']);
            $table->index('post_id');

            $table->timestamps();
            $table->softDeletes();
        });
       }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         if(Schema::hasTable('posts_images')) {
            Schema::dropIfExists('posts_images');
        }
    }
}
