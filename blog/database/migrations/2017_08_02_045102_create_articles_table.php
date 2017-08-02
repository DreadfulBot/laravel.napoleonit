<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
           $table->increments('id')->index();
           $table->integer('category_id');
           $table->string('image');
           $table->string('title');
           $table->string('description');
           $table->string('content');
           $table->timestamp('created_at');
           $table->timestamp('updated_at');

           $table->foreign('category_id')->references('id')->on('categories');
        });


        DB::table('articles')->insert([
            'category_id' => 1,
            'image' => "",
            'title' => "hello world title",
            'description' => "hello world description",
            'content' => 'hello world content',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
