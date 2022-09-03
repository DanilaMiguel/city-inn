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
        Schema::create('map_pins', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->string("link")->nullable();
            $table->double("latitude")->nullable();
            $table->double("longitude")->nullable();
            $table->boolean("is_center");
            $table->integer("zoom");
            $table->integer("sort");
            $table->string("map_key")->nullable();
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
        Schema::dropIfExists('map_pins');
    }
};
