<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_items_id')->unsigned();

            $table->string('name');
            $table->text('compact_name')->nullable();

            $table->string('locale')->index();

            $table->unique(['menu_items_id','locale']);
            $table->foreign('menu_items_id')->references('id')->on('menu_items')->onDelete('cascade');
        
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
        Schema::dropIfExists('menu_items_translations');
    }
}
