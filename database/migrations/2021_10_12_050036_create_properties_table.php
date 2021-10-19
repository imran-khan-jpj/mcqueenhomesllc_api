<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string("type", 50); // Home or Land
            $table->string("description", 50)->nullable(); 
            $table->integer('NoOfBeds')->nullable(); // Number of beds have if type is home 
            $table->integer('NoOfBaths')->nullable(); // Number of bath if type is home
            $table->string('propertyFor', 50); // sale or rent
            $table->string("longitude", 50)->nullable();
            $table->string("latitude", 50)->nullable();
            $table->string('currentStatus', 50); // [avaialble for rent, currently rented, available for sale, sold]
            $table->timestamps();
            
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
