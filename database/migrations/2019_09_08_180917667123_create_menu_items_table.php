<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->nullable();
            $table->integer('parent_item_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->string('route_param_name_1')->nullable();
            $table->string('route_param_name_2')->nullable();
            $table->string('route_param_name_3')->nullable();
            $table->string('route_param_value_1')->nullable();
            $table->string('route_param_value_2')->nullable();
            $table->string('route_param_value_3')->nullable();
            $table->string('font_awesome_class')->nullable();
            $table->boolean('hide_name')->default('0');
            $table->integer('order')->nullable();
            $table->integer('access')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
