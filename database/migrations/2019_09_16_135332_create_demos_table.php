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

            $table->unsignedBigInteger('designer_id')->nullable()->comment('designer id');
            $table->foreign('designer_id')->references('id')->on('designers')->onDelete('SET NULL');

            $table->unsignedBigInteger('client_id')->nullable()->comment('client id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('SET NULL');

            $table->string('name')->nullable(false)->comment('name');
            $table->text('description')->nullable()->comment('description'); // 备用字段
            $table->text('content')->nullable()->comment('content'); // 备用字段

            $table->string('thumb')->nullable()->comment('缩略图');
            $table->json('photos')->nullable()->comment('图片集');

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
