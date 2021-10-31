<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('property_type');
            $table->string('address');
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();
            $table->integer('min_area')->nullable();
            $table->integer('max_area')->nullable();
            $table->integer('min_year_of_construction')->nullable();
            $table->integer('max_year_of_construction')->nullable();
            $table->integer('min_rooms')->nullable();
            $table->integer('max_rooms')->nullable();
            $table->integer('min_potential_return')->nullable();
            $table->integer('max_potential_return')->nullable();
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
        Schema::dropIfExists('search_profiles');
    }
}
