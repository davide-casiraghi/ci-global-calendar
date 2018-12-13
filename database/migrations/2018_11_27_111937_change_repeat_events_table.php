<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRepeatEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('repeat_until');
            $table->dropColumn('repeat_weekly_on');
            $table->dropColumn('repeat_monthly_on');
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
            $table->dateTime('repeat_until')->nullable();
            $table->string('repeat_weekly_on')->nullable();
            $table->string('repeat_monthly_on')->nullable();
        });
    }
}
