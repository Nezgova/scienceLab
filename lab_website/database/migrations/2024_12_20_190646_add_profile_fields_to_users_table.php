<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('profile_picture')->nullable();
        $table->text('description')->nullable();
        $table->string('sex')->nullable();
        $table->string('specialties')->nullable();
        $table->string('interests')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
