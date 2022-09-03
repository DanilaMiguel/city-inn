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
        Schema::create('group_requests', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("subtitle")->nullable();
            $table->text("description")->nullable();
            $table->string("images")->nullable();
            $table->string("tablet_images")->nullable();
            $table->string("mobile_images")->nullable();
            $table->integer("sort");
            $table->boolean("active");
            $table->boolean("is_smart_number");
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
        Schema::dropIfExists('group_requests');
    }
};
