<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name')->unique();
            $table->string('address');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('postal_code');
            $table->uuid('created_by');
            $table->uuid('last_modified');

            $table->boolean('isGlobal')->default(0);

            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('last_modified')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
