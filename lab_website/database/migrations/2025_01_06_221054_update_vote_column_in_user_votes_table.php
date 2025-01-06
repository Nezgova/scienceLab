<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVoteColumnInUserVotesTable extends Migration
{
    public function up()
    {
        Schema::table('user_votes', function (Blueprint $table) {
            $table->integer('vote')->default(0)->change(); // Change 'vote' column to integer
        });
    }

    public function down()
    {
        Schema::table('user_votes', function (Blueprint $table) {
            $table->enum('vote', ['up', 'down'])->change(); // Revert to original enum type
        });
    }
};
