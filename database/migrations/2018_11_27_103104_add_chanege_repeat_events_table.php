<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChanegeRepeatEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('weekly_on');
            $table->dropColumn('monthly_on');
            $table->string('repeat_weekly_on');
            $table->string('repeat_monthly_on');
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
            $table->string('weekly_on');
            $table->string('monthly_on');
            $table->dropColumn('repeat_weekly_on');
            $table->dropColumn('repeat_monthly_on');
        });
    }
}
