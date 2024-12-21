<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_votes')) {
            Schema::create('user_votes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
                $table->enum('vote', ['up', 'down']);
                $table->timestamps();
            });
        }
    }
    

    public function down(): void
    {
        Schema::dropIfExists('user_votes');
    }
};
