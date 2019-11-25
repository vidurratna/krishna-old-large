<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->uuid('id');
            //links
            $table->uuid('created_by');
            $table->uuid('last_modified');
            //data
            $table->string('name');
            $table->string('slug')->unique();
            //$table->address
            $table->timestamps();
            // links
            $table->primary('id');
            $table->foreign('last_modified')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venues');
    }
}
