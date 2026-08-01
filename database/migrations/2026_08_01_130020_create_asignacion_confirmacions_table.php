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
        Schema::create('asignacion_confirmacions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('asignacion_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('respuesta', [
                'pendiente',
                'confirmado',
                'rechazado',
            ])
                ->default('pendiente');

            $table->timestamp('respondido_at')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_confirmacions');
    }
};
