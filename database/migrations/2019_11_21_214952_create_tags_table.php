<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            //links
            $table->uuid('chapter_id');
            $table->uuid('created_by');
            $table->uuid('last_modified');
            //data
            $table->string('name');
            $table->string('slug');
            $table->boolean('isGlobal')->default(0);
            $table->json('hashtags')->nullable();
            $table->timestamps();
            //settings
            $table->unique(['chapter_id','name']);
            $table->unique(['chapter_id','slug']);
            //links
            $table->foreign('chapter_id')->references('id')->on('chapters');
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
        Schema::dropIfExists('tags');
    }
}
