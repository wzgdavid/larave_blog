<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassifiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classified', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_individual')->default(0);
            $table->string('title', 200);
            $table->string('slug', 200);
            $table->text('content')->nullable();
            $table->datetime('start_datetime')->nullable();
            $table->datetime('end_datetime')->nullable();
            $table->string('price', 200);
            $table->integer('size')->nullable();
            $table->boolean('is_shared')->default(0);
            $table->boolean('is_agency')->default(0);
            $table->string('geo_location', 100);
            $table->string('size_square', 20);
            $table->integer('contributor_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->datetime('create_datetime');
            $table->string('forum_url', 400);
            $table->boolean('featured')->default(0);
            $table->integer('category_id')->nullable();
            $table->integer('merto_line');
            $table->integer('station');
            $table->datetime('date_modified');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classified');
    }
}
