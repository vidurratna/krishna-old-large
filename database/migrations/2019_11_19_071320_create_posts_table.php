<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            //f-keys
            $table->uuid('chapter_id');
            $table->uuid('created_by');
            //content
            $table->string('title');
            $table->string('slug');
            $table->boolean('isGlobal')->default(0);
            $table->timestamp('published')->nullable();
            $table->timestamps();
            //settings
            $table->unique(['chapter_id','slug']);
            //links
            $table->foreign('chapter_id')->references('id')->on('chapters');
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
        Schema::dropIfExists('posts');
    }
}
