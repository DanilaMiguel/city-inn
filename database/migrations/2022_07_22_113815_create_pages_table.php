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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("subtitle")->nullable();
            $table->text("description");
            $table->integer("sort");
            $table->text("seo_title");
            $table->text("seo_description");
            $table->string("head_image");
            $table->string("tablet_head_image");
            $table->string("mobile_head_image");
            $table->text("section_title")->nullable();
            $table->text("section_name")->nullable();
            $table->string("section_image")->nullable();
            $table->string("tablet_section_image")->nullable();
            $table->string("mobile_section_image")->nullable();
            $table->text("header_one")->nullable();
            $table->text("header_two")->nullable();
            $table->boolean("show_on_main");
            $table->text("reserve_text")->nullable();
            $table->string("reserve_link")->nullable();
            $table->text("more_text")->nullable();
            $table->string("more_link")->nullable();
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
        Schema::dropIfExists('pages');
    }
};
