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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->string("code");
            $table->string("xml_id");
            $table->integer("sort");
            $table->string("preview_image");
            $table->string("tablet_preview_image");
            $table->string("mobile_preview_image");
            $table->text("description");
            $table->boolean("active");
            $table->string("book_link");
            $table->text("seo_title");
            $table->text("seo_description",2000);
            $table->string("images");
            $table->string("tablet_images");
            $table->string("mobile_images");
            $table->bigInteger("price");
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
        Schema::dropIfExists('rooms');
    }
};
