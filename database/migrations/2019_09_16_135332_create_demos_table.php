<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('scenario')->nullable(false)->default('PC')->comment('scenario: PC || Mobile');
            $table->string('name')->nullable(false)->comment('name');
            $table->string('slug')->nullable()->comment('slug');
            $table->text('description')->nullable()->comment('description');
            $table->text('memo')->nullable()->comment('备注信息');

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
        Schema::dropIfExists('demos');
    }
}
