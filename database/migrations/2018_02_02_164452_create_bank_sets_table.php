<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankSetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_sets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('银行卡名称');
            $table->string('img')->nullable()->comment('图片');

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
        Schema::drop('bank_sets');
    }
}
