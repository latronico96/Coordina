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
        Schema::create('iglesias', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->string('direccion')->nullable();
            $table->boolean('activo')->default(true);
            // Personalización
            $table->string('logo_url')->nullable();
            $table->string('color_primario', 20)->nullable();
            $table->string('color_secundario', 20)->nullable();

            // Google Calendar
            $table->boolean('google_calendar_habilitado')->default(false);
            $table->string('google_calendar_id')->nullable();

            // Datos de contacto
            $table->string('email_contacto')->nullable();
            $table->string('telefono_contacto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iglesias');
    }
};
