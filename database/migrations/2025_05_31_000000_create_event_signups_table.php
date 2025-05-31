<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_signups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->timestamp('signed_up_at')->useCurrent();
            $table->text('notes')->nullable();
            $table->enum('status', ['registered', 'cancelled', 'attended', 'no_show'])->default('registered');
            $table->timestamps();

            $table->unique(['event_id', 'member_id']);
            $table->index(['event_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_signups');
    }
};