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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("header")->nullable();
            $table->text("description")->nullable();
            $table->text("description_adder")->nullable();
            $table->string("image");
            $table->string("tablet_image");
            $table->string("mobile_image");
            $table->integer("sort");
            $table->text("button_text")->nullable();
            $table->text("button_link")->nullable();
            $table->text("work_start")->nullable();
            $table->text("work_end")->nullable();
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
        Schema::dropIfExists('slides');
    }
};
