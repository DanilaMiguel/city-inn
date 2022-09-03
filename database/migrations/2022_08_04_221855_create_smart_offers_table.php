<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smart_offers', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("description")->nullable();
            $table->string("image");
            $table->string("tablet_image");
            $table->string("mobile_image");
            $table->text("book_text")->nullable();
            $table->text("book_link")->nullable();
            $table->text("button_text")->nullable();
            $table->text("button_link")->nullable();
            $table->integer("sort");
            $table->boolean("active");
            $table->time('work_start')->nullable();
            $table->time('work_end')->nullable();
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
        Schema::dropIfExists('smart_offers');
    }
};
