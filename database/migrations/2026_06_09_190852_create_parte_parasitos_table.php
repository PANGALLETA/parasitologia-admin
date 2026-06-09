<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parte_parasitos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('parasito_id')
                ->constrained('parasitos')
                ->cascadeOnDelete();

            $table->string('nombre');

            $table->string('imagen');

            $table->text('descripcion');

            $table->unsignedTinyInteger('orden')
                ->default(1);

            $table->boolean('activo')
                ->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parte_parasitos');
    }
};