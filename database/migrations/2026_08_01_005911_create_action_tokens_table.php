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
        Schema::create('action_tokens', function (Blueprint $table) {
            $table->id();

            $table->string('token', 64)->unique();

            $table->string('tipo');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->json('payload')
                ->nullable();

            $table->timestamp('expires_at');

            $table->timestamp('used_at')
                ->nullable();

            $table->timestamps();

            $table->index('tipo');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_tokens');
    }
};
