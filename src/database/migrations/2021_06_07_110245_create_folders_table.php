<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')
                ->unique();
            $table->tinyText('short')
                ->nullable()
                ->comment("Краткое описанрие");

            $table->string('main_image')
                ->nullable();
            $table->unsignedBigInteger("parent_id")
                ->nullable()
                ->comment("Родительская папка");

            $table->unsignedBigInteger("priority")
                ->default(0)
                ->comment("Приоритет");

            $table->dateTime("published_at")
                ->nullable()
                ->comment("Дата публикации");
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
        Schema::dropIfExists('folders');
    }
}
