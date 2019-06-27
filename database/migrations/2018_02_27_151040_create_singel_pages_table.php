<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSingelPagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('singel_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('名称');
            $table->string('slug')->nullable()->comment('别名');
            $table->longtext('content')->nullable()->comment('正文');
            $table->integer('view')->nullable()->default(1)->comment('浏览量');

            $table->index(['id', 'created_at']);
            $table->index('slug');

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
        Schema::drop('singel_pages');
    }
}
