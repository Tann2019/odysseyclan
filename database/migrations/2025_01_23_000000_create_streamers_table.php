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
        Schema::create('streamers', function (Blueprint $table) {
            $table->id();
            $table->string('twitch_username')->unique();
            $table->string('display_name');
            $table->integer('priority')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_live')->default(false);
            $table->timestamp('last_checked_at')->nullable();
            $table->json('stream_data')->nullable(); // Store additional stream info
            $table->timestamps();
            
            $table->index(['is_active', 'priority']);
            $table->index(['is_live', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('streamers');
    }
};