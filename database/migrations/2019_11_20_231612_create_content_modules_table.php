<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_modules', function (Blueprint $table) {
            $table->uuid('id');
            // fkeys
            $table->uuid('chapter_id');
            $table->morphs('content_module');
            //data
            $table->string('name');
            $table->text('description');
            $table->string('type');
            $table->integer('priority');
            $table->json('content');
            $table->timestamps();
            //links
            $table->foreign('chapter_id')->references('id')->on('chapters');
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_modules');
    }
}
