<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_approved')->default(0);
            $table->boolean('is_special')->default(0);
            $table->boolean('is_welcome')->default(0);
            $table->integer('category_id');
            $table->integer('user_id');
            $table->datetime('date_created');// change to created_at
            $table->datetime('date_modified'); // updated_at
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
            $table->boolean('is_in_sitemap')->default(0);
            $table->boolean('is_proofread')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
