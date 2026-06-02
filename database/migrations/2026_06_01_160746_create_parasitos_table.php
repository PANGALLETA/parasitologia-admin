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

        $table->uuid('uuid')->unique();

        $table->string('nombre_comun');
        $table->string('nombre_cientifico')->unique();

        $table->string('familia')->nullable();
        $table->string('genero')->nullable();

        $table->longText('descripcion_general')->nullable();
        $table->longText('morfologia')->nullable();
        $table->longText('hospedadores')->nullable();
        $table->longText('sintomas')->nullable();
        $table->longText('tratamiento')->nullable();

        $table->string('imagen_principal')->nullable();

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
