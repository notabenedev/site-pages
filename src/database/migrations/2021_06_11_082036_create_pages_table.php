<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {

            $table->increments('id');

            $table->string('title');

            $table->string('slug')
                ->unique();

            $table->tinyText('short')
                ->nullable()
                ->comment("Краткое описание");

            $table->text("description")
                ->nullable()
                ->comment("Описание");

            $table->string("accent")
                ->nullable()
                ->comment("Акцент");

            $table->tinyText("comment")
                ->nullable()
                ->comment("Комментарий");


            $table->string('main_image')
                ->nullable();

            $table->unsignedBigInteger("folder_id")
                ->nullable()
                ->comment("Категория страницы");

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
        Schema::dropIfExists('pages');
    }
}
