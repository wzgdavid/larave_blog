<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModityArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article', function (Blueprint $table) {
            $table->boolean('is_in_sitemap')->default(0);
            $table->boolean('is_proofread')->default(0);
            //$table->datetime('date_created')->timestamp('created_at')->change();
            //$table->datetime('date_modified')->timestamp('updated_at')->change();
            //$table->renameColumn('date_created', 'created_at');
            //$table->renameColumn('date_modified', 'updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article', function (Blueprint $table) {
            //
        });
    }
}
