<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_product', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');

            $table->index(['id', 'created_at']);

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
        Schema::dropIfExists('post_product');
    }
}
