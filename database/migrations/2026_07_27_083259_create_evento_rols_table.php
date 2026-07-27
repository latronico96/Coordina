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
        Schema::create('evento_rols', function (Blueprint $table) {
            $table->id();

            $table->foreignId('evento_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('rol_servicio_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('cantidad')
                ->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_rols');
    }
};
