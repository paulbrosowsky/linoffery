<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cargo_id');
            $table->string('title');
            $table->string('description');
            $table->string('pallet');
            $table->unsignedInteger('weight');
            $table->unsignedInteger('width');
            $table->unsignedInteger('depth');
            $table->unsignedInteger('height');
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
        Schema::dropIfExists('freights');
    }
}
