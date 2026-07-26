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
        Schema::create('evento_recurrentes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('iglesia_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('nombre');

            $table->unsignedTinyInteger('dia_semana');

            $table->time('hora_inicio');

            $table->boolean('activo')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_recurrentes');
    }
};
