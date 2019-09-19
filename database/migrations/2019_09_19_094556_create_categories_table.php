<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('demo_id')->nullable(false)->comment('demo id');
            $table->foreign('demo_id')->references('id')->on('demos')->onDelete('cascade');

            $table->string('name')->nullable(false)->comment('name');
            $table->string('slug')->nullable()->comment('slug');
            $table->unsignedSmallInteger('sort')->nullable(false)->default(9)->comment('排序值');

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
        Schema::dropIfExists('categories');
    }
}
