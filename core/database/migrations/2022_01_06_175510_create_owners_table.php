<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 40)->nullable();
            $table->string('lastname', 40)->nullable();
            $table->string('username', 40);
            $table->string('mobile', 40)->nullable();
            $table->string('email', 40);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('country_code', 40);
            $table->string('image', 255)->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('ev')->default(0);
            $table->tinyInteger('sv')->default(0);
            $table->string('ver_code', 40)->nullable();
            $table->dateTime('ver_code_send_at');
            $table->tinyInteger('ts')->default(0);
            $table->tinyInteger('tv')->default(1);
            $table->string('tsc', 255)->nullable();
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
        Schema::dropIfExists('owners');
    }
}
