<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnNameCompactNameSlug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_item_translations', function (Blueprint $table) {
            $table->renameColumn('compact_name', 'slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_item_translations', function (Blueprint $table) {
            $table->renameColumn('slug', 'compact_name');
        });
    }
}
