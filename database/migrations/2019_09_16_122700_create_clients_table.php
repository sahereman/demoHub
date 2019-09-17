<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable(false)->comment('name');
            $table->string('avatar')->nullable()->comment('avatar');
            $table->string('email')->nullable()->comment('email');
            $table->string('gender')->nullable(false)->default('male')->comment('gender');
            $table->string('qq')->nullable()->comment('QQ');
            $table->string('wechat')->nullable()->comment('微信');
            $table->string('phone')->nullable()->comment('phone');

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
        Schema::dropIfExists('clients');
    }
}
