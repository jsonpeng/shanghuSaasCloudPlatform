<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTechniciansImagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('technician_id')->unsigned();
            $table->foreign('technician_id')->references('id')->on('technicians');

            $table->index(['id', 'created_at']);
            $table->index('technician_id');

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
        Schema::drop('technicians_images');
    }
}
