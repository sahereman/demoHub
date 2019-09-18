<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoDesignersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_designers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('demo_id')->nullable(false)->comment('demo id');
            $table->foreign('demo_id')->references('id')->on('demos')->onDelete('cascade');

            $table->unsignedInteger('admin_user_id')->nullable(false)->comment('admin_user id');
            $table->foreign('admin_user_id')->references('id')->on('admin_users')->onDelete('cascade');

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
        Schema::dropIfExists('demo_designers');
    }
}
