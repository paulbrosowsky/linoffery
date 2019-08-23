<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id');
            $table->string('title_image')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedInteger('immediate_price')->nullable();
            $table->unsignedInteger('max_price')->nullable();
            $table->unsignedInteger('lowest_offer')->nullable();
            $table->dateTime('valid_date'); 
            $table->dateTime('published_at')->nullable();   
            $table->dateTime('completed_at')->nullable();                   
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
        Schema::dropIfExists('tenders');
    }
}
