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
        Schema::create('disponibilidad_servidors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('servidor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('fecha');

            $table->string('motivo')->nullable();

            $table->timestamps();

            $table->unique([
                'servidor_id',
                'fecha',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disponibilidad_servidors');
    }
};
