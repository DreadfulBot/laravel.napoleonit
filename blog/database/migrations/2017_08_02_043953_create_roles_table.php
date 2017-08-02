<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('role');
            $table->text('permissions');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        DB::table('roles')->insert([
            'role' => 'admin',
            'permissions' => '{"category.list":true, 
                "category.view":true,
                "category.update":true,
                "category.delete":true,
                "category.create":true,
                "user.list":true,
                "user.view":true,
                "user.update":true,
                "user.delete":true,
                "user.create":true,
                "article.list": true,
                "article.view":true,
                "article.update":true,
                "article.delete":true,
                "article.create":true}',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
            ]);

        DB::table('roles')->insert([
            'role' => 'user',
            'permissions' => '{"category.list":true, 
                "category.view":true,
                "category.update":false,
                "category.delete":false,
                "category.create":false,
                "user.list":true,
                "user.view":true,
                "user.update":false,
                "user.delete":false,
                "user.create":false,
                "article.list": true,
                "article.view":true,
                "article.update":false,
                "article.delete":false,
                "article.create":false}',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
