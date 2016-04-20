<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort');
            $table->string('name',100);
            $table->integer('tid')->nullable();
            $table->string('slug',100);
            $table->integer('main_category_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('sort_order');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_category');
    }
}
