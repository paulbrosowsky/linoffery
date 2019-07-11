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
            $table->unsignedInteger('cargo_id');
            $table->string('type');            
            $table->string('country');
            $table->string('city');
            $table->string('zip');  
            $table->string('address');          
            $table->float('lat');
            $table->float('lng');
            $table->unsignedSmallInteger('latency');
            $table->string('latest_date');
            $table->string('earliest_date');
            $table->boolean('loading')->default(true);
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
