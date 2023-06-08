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
            $table->string('name', 40)->nullable();
            $table->unsignedInteger('property_id')->default(0);
            $table->unsignedInteger('location_id')->default(0);
            $table->unsignedInteger('amenity_id')->default(0);
            $table->decimal('rating', 28, 8)->default(0);
            $table->unsignedInteger('review')->default(0);
            $table->text('description')->nullable();
            $table->text('map_url')->nullable();
            $table->string('image', 40)->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('phone_call_time', 255)->nullable();
            $table->tinyInteger('status')->default(1);
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
