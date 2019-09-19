<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('category_id')->nullable(false)->comment('category id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('name')->nullable(false)->comment('name');
            $table->string('slug')->nullable()->comment('slug');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->string('photo')->nullable(false)->comment('图片');
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
        Schema::dropIfExists('drafts');
    }
}
