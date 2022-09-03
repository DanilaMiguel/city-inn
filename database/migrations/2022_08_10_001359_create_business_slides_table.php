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
        Schema::create('business_slides', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("description")->nullable();
            $table->text("description_adder")->nullable();
            $table->string("image");
            $table->string("tablet_image");
            $table->string("mobile_image");
            $table->integer("price")->nullable();
            $table->text("price_for")->nullable();
            $table->text("pre_price")->nullable();
            $table->text("button_text")->nullable();
            $table->string("button_link")->nullable();
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
        Schema::dropIfExists('business_slides');
    }
};
