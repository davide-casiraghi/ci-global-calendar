<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FacebookAndWebsiteLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('website_event_link')->nullable();
            $table->string('facebook_event_link')->nullable();
            $table->dropColumn('facebook_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('website_event_link');
            $table->dropColumn('facebook_event_link');
            $table->string('facebook_link')->nullable();
        });
    }
}
