<?php

use App\Models\Character;
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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', [Character::ALIVE, Character::DEAD, Character::UNKNOWN])->default(Character::ALIVE);
            $table->string('species');
            $table->string('type')->nullable();
            $table->string('gender');
            $table->string('slug')->unique();
            // $table->unsignedBigInteger('origin_id');
            // $table->foreign('origin_id')->references('id')->table('locations');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');

            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->table('users');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
