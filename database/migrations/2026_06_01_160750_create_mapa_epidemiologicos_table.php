<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mapa_epidemiologicos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('parasito_id')
                ->constrained('parasitos')
                ->cascadeOnDelete();

            $table->string('departamento');

            $table->enum('nivel_presencia', [
                'alta',
                'media',
                'baja'
            ]);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->unique([
                'parasito_id',
                'departamento'
            ]);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mapa_epidemiologicos');
    }
};