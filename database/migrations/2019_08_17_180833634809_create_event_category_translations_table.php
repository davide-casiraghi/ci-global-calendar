<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCategoryTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('event_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_category_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['event_category_id', 'locale']);
            $table->foreign('event_category_id')->references('id')->on('event_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_category_translations');
    }
}
