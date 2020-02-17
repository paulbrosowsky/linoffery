<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransportTypeIdToFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('freights', function (Blueprint $table) {
            $table->unsignedInteger('transport_type_id')->nullable(); 
            $table->string('pallet')->nullable()->change();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('freights', function (Blueprint $table) {
            $table->unsignedInteger('transport_type_id')->nullable();
        });
    }
}
