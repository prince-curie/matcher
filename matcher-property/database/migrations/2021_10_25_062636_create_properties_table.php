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
            $table->string('name');
            $table->string('property_type');
            $table->string('address');
            $table->integer('price')->nullable();
            $table->integer('area')->nullable();
            $table->integer('construction_year')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('actual_return')->nullable();
            $table->boolean('parking')->nullable();
            $table->string('heating_type')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
