<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrientationToBackgroundImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('background_images', function (Blueprint $table) {
            $table->string('orientation');
            $table->dropColumn('folder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('background_images', function (Blueprint $table) {
            $table->dropColumn('orientation');
            $table->string('folder');
        });
    }
}
