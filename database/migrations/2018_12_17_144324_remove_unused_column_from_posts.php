<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedColumnFromPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->dropColumn('image');
            $table->dropColumn('seo_title');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('author_id');
            $table->string('image')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('meta_description');
            $table->text('meta_keywords');
        });
    }
}
