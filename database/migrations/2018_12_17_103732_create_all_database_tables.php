<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllDatabaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('group')->nullable();
            $table->integer('country_id')->nullable();
            $table->text('description')->nullable();
            $table->string('activation_code')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('accept_terms')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('created_by')->nullable();

            $table->text('body');
            $table->integer('category_id')->nullable();

            $table->string('status')->default('2');
            $table->boolean('featured')->default(0);

            $table->text('before_content')->nullable();
            $table->text('after_content')->nullable();

            $table->string('introimage')->nullable();
            $table->string('introimage_alt')->nullable();

            $table->string('slug');

            $table->timestamps();
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();

            $table->string('slug');

            $table->timestamps();
        });
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->nullable();

            $table->text('bio')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('year_starting_practice')->nullable();
            $table->string('year_starting_teach')->nullable();
            $table->text('significant_teachers')->nullable();

            $table->string('profile_picture')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();

            $table->string('slug');

            $table->timestamps();
        });
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('created_by')->nullable();

            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('venue_id');
            $table->integer('organized_by')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_event_link')->nullable();
            $table->string('facebook_event_link')->nullable();
            $table->string('status')->default('2')->nullable();

            $table->integer('repeat_type');
            $table->dateTime('repeat_until')->nullable();
            $table->string('repeat_weekly_on')->nullable();
            $table->string('repeat_monthly_on')->nullable();
            $table->string('on_monthly_kind')->nullable();

            $table->integer('sc_country_id')->nullable();
            $table->string('sc_country_name')->nullable();
            $table->string('sc_city_name')->nullable();
            $table->string('sc_venue_name')->nullable();
            $table->string('sc_teachers_id')->nullable();
            $table->string('sc_teachers_names')->nullable();
            $table->integer('sc_continent_id')->nullable();
            $table->string('multiple_dates')->nullable();

            $table->string('slug');

            $table->timestamps();
        });
        Schema::create('event_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('event_repetitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->dateTime('start_repeat');
            $table->dateTime('end_repeat');
            $table->timestamps();
        });
        Schema::create('event_venues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('website')->nullable();
            $table->integer('continent_id');
            $table->integer('country_id');
            $table->string('state_province')->nullable();
            $table->string('city');
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
        });
        Schema::create('continents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('continent_id');
            $table->timestamps();
        });
        Schema::create('event_has_teachers', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('teacher_id');
        });
        Schema::create('event_has_organizers', function (Blueprint $table) {
            $table->integer('event_id');
            $table->integer('organizer_id');
        });
        Schema::create('organizers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by')->nullable();

            $table->string('email');
            $table->text('description')->nullable();
            $table->integer('country_id')->nullable();

            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('phone')->nullable();

            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('background_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('image_src')->unique();
            $table->string('credits')->nullable();
            $table->boolean('orientation');
            $table->timestamps();
        });
        Schema::create('post_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();

            $table->string('title');
            $table->text('body')->nullable();
            $table->string('slug')->nullable();
            $table->text('before_content')->nullable();
            $table->text('after_content')->nullable();

            $table->string('locale')->index();

            $table->unique(['post_id', 'locale']);
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('position')->nullable();
            $table->integer('order')->nullable();
            $table->integer('access')->nullable();
            $table->timestamps();
        });
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('menu_id')->nullable();
            $table->string('parent_item_id')->nullable();
            $table->integer('type')->nullable();
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->string('font_awesome_class')->nullable();
            $table->boolean('hide_name')->default('0');
            $table->string('compact_name');
            $table->integer('order')->nullable();
            $table->integer('access')->nullable();
            $table->string('route_param_name_1')->nullable();
            $table->string('route_param_name_2')->nullable();
            $table->string('route_param_name_3')->nullable();
            $table->string('route_param_value_1')->nullable();
            $table->string('route_param_value_2')->nullable();
            $table->string('route_param_value_3')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_item_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_item_id')->unsigned();

            $table->string('name');
            $table->text('compact_name')->nullable();

            $table->string('locale')->index();

            $table->unique(['menu_item_id', 'locale']);
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug');

            $table->string('locale')->index();

            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('event_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_category_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['event_category_id', 'locale']);
            $table->foreign('event_category_id')->references('id')->on('event_categories')->onDelete('cascade');
        });

        Schema::create('donation_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->integer('created_by')->nullable();
            $table->integer('country_id')->nullable();
            $table->text('contact_trough_voip')->nullable();
            $table->text('language_spoken')->nullable();
            $table->integer('offer_kind')->nullable();
            $table->integer('gift_kind')->nullable();
            $table->text('gift_description')->nullable();
            $table->integer('volunteer_kind')->nullable();
            $table->text('volunteer_description')->nullable();
            $table->text('other_description')->nullable();
            $table->text('suggestions')->nullable();
            $table->integer('status')->default(1);
            $table->string('gift_title')->nullable();
            $table->string('gift_donater')->nullable();
            $table->string('gift_economic_value')->nullable();
            $table->string('gift_volunteer_time_value')->nullable();
            $table->string('gift_given_to')->nullable();
            $table->dateTime('gift_given_when')->nullable();
            $table->integer('gift_country_of')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registered_users_number')->nullable();
            $table->integer('organizers_number')->nullable();
            $table->integer('teachers_number')->nullable();
            $table->integer('active_events_number')->nullable();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_repetitions');
        Schema::dropIfExists('event_venues');
        Schema::dropIfExists('continents');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('event_has_teachers');
        Schema::dropIfExists('organizers');
        Schema::dropIfExists('event_has_organizers');
        Schema::dropIfExists('background_images');
        Schema::table('post_translations', function (Blueprint $table) {
            $table->dropForeign('post_translations_post_id_foreign');
        });
        Schema::dropIfExists('post_translations');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('menus');

        Schema::table('menu_item_translations', function (Blueprint $table) {
            $table->dropForeign('menu_item_translations_menu_item_id_foreign');
        });
        Schema::dropIfExists('menu_item_translations');
        Schema::dropIfExists('menu_items');

        Schema::table('category_translations', function (Blueprint $table) {
            $table->dropForeign('category_translations_category_id_foreign');
        });
        Schema::dropIfExists('category_translations');
        Schema::dropIfExists('categories');

        Schema::table('event_category_translations', function (Blueprint $table) {
            $table->dropForeign('event_category_translations_event_category_id_foreign');
        });
        Schema::dropIfExists('event_category_translations');
        Schema::dropIfExists('event_categories');
        Schema::dropIfExists('donation_offers');
        Schema::dropIfExists('statistics');
    }
}
