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
        Schema::create('character_episode', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('character_id');
            // $table->foreign('character_id')->references('id')->table('characters');
            $table->foreignId('character_id')->constrained()->onDelete('cascade');

            // $table->unsignedBigInteger('episode_id');
            // $table->foreign('episode_id')->references('id')->table('episodes');
            $table->foreignId('episode_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_episode');
    }
};
