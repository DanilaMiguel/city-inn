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
        Schema::create('lobbies', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("description")->nullable();
            $table->integer("sort");
            $table->boolean("active");
            $table->string("image");
            $table->string("tablet_image");
            $table->string("mobile_image");
            $table->text("menu_text")->nullable();
            $table->text("menu_link")->nullable();
            $table->text("book_text")->nullable();
            $table->text("book_link")->nullable();
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
        Schema::dropIfExists('lobbies');
    }
};
