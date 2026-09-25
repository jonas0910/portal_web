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
        Schema::create('gc_miembros_colegio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->enum('tipo', ['notario', 'junta_directiva', 'tribunal_honor', 'decano_historico'])->default('notario');
            $table->string('cargo')->nullable(); // Para Junta/Tribunal
            $table->string('periodo')->nullable(); // Para Junta/Tribunal/Histórico
            $table->string('notaria')->nullable(); // Solo Notarios
            $table->string('direccion')->nullable();
            $table->string('distrito')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->text('biografia')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gc_miembros_colegio');
    }
};
