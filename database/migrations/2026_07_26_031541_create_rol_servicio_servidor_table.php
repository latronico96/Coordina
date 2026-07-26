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
        Schema::create('rol_servicio_servidor', function (Blueprint $table) {
            $table->id();

            $table->foreignId('servidor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('rol_servicio_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'servidor_id',
                'rol_servicio_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_servicio_servidor');
    }
};
