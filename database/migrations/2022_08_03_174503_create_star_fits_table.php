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
        Schema::create('star_fits', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("text_top")->nullable();
            $table->text("text_bottom")->nullable();
            $table->string("images")->nullable();
            $table->string("tablet_images")->nullable();
            $table->string("mobile_images")->nullable();
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
        Schema::dropIfExists('star_fits');
    }
};
