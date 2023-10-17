<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_studio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_id')
                ->references('id')
                ->on('studios')
                ->cascadeOnDelete();
            $table->foreignId('movie_id')
                ->references('id')
                ->on('movies')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_studio');
    }
};
