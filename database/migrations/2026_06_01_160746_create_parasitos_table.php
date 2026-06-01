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
        Schema::create('parasitos', function (Blueprint $table) {
            $table->id();

            // Información taxonómica
            $table->string('nombre_cientifico');
            $table->string('nombre_comun')->nullable();
            $table->string('familia')->nullable();
            $table->string('orden_taxonomico')->nullable();

            // Información general
            $table->longText('descripcion_general');
            $table->longText('ciclo_vida')->nullable();

            // Información veterinaria
            $table->text('hospedadores')->nullable();
            $table->text('sintomas')->nullable();
            $table->text('tratamiento')->nullable();

            // Imagen principal
            $table->string('imagen_principal')->nullable();

            // Estado
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parasitos');
    }
};
