<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorIdToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // If column already exists, no need to add it again
            if (!Schema::hasColumn('articles', 'author_id')) {
                $table->unsignedBigInteger('author_id')->after('id');
                $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['author_id']); // Drops the foreign key
            $table->dropColumn('author_id'); // Drops the 'author_id' column
        });
    }
}
