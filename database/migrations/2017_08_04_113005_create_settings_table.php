<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->default('')->nullable()->comment('属性名称');
            $table->string('value', 512)->default('')->nullable()->comment('属性值');
            $table->string('group', 50)->default('')->nullable()->comment('属性分组');
            $table->string('des', 50)->default('')->nullable()->comment('属性描述');

            $table->string('account')->nullable()->comment('租户');
            $table->integer('shop_id')->nullable()->unsigned();
            $table->foreign('shop_id')->references('id')->on('store_shops');
            $table->index('account');
            $table->index('shop_id');

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
        Schema::drop('settings');
    }
}
