<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('tender_id');
            $table->string('type');
            $table->string('address');          
            $table->float('lat');
            $table->float('lng');
            $table->unsignedSmallInteger('latency')->nullable();
            $table->string('latest_date');
            $table->string('earliest_date');
            $table->boolean('loading')->nullable();
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
        Schema::dropIfExists('locations');
    }
}
