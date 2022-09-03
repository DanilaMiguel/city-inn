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
        Schema::create('conference_services', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("description");
            $table->string("head_image");
            $table->string("tablet_head_image");
            $table->string("mobile_head_image");

            $table->text("section_title");
            $table->text("section_description");
            $table->string("preview_image");
            $table->string("tablet_preview_image");
            $table->string("mobile_preview_image");

            $table->text("seo_title");
            $table->text("seo_description");
            $table->string("code");
            $table->boolean("active");
            $table->integer("sort");

            $table->text("why_title");
            $table->string("why_images");
            $table->string("tablet_why_images");
            $table->string("mobile_why_images");

            $table->text("park_title");
            $table->string("park_image");
            $table->string("tablet_park_image");
            $table->string("mobile_park_image");
            $table->text("park_description");

            $table->text("button_text");
            $table->text("button_link");
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
        Schema::dropIfExists('conference_services');
    }
};
