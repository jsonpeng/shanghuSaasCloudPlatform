<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('word', function (Blueprint $table){
            $table->increments('id');
            $table->string('name')->nullable()->comment('套餐条目名称');
            $table->longtext('intro')->nullable()->comment('套餐条目描述');

            $table->index(['id', 'created_at']);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('package_word', function (Blueprint $table){
            $table->increments('id');

            $table->integer('word_id')->unsigned();
            $table->foreign('word_id')->references('id')->on('word');

            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('charge_packages');

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
        Schema::dropIfExists('package_word');
        Schema::dropIfExists('word');
    }
}
