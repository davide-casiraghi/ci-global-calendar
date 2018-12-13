<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFacebookLinkColumnNameEventVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_venues', function (Blueprint $table) {
            $table->renameColumn('facebook_link', 'facebook');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_venues', function (Blueprint $table) {
            $table->renameColumn('facebook', 'facebook_link');
        });
    }
}
