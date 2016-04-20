<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_special')->default(0);
            $table->boolean('is_welcome')->default(0);
            $table->integer('category_id');
            $table->integer('user_id');
            $table->datetime('date_created');
            $table->datetime('date_modified');
            $table->string('title', 200);
            $table->text('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->string('page_title', 300)->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('nid')->nullable();
            $table->string('hyperlink', 250)->nullable();
            $table->string('keywords', 500)->nullable();
            $table->string('pic', 256)->nullable();
            $table->text('related_threads')->nullable();
            $table->boolean('is_shf_featured')->default(0);
            $table->boolean('is_shf_sponsored')->default(0);
            $table->boolean('is_homepage_sponsored')->default(0);
            $table->integer('author_id');
            $table->integer('shf_priority');
            $table->boolean('is_home_featured')->default(0);
            $table->datetime('datetime_publish');
            $table->datetime('datetime_unpublish');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article');
    }
}
