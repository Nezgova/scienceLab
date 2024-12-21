<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
                Schema::table('users', function (Blueprint $table) {
                    $table->text('description')->nullable();
                    $table->string('sex')->nullable();
                    $table->string('specialties')->nullable(); // Store as a comma-separated string
                    $table->string('interests')->nullable(); // Store as a comma-separated string
                });

            });
        }
    }
    
    

    
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
