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
        Schema::create('asistencia_talleres', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_asistencia');
            $table->integer('horas_asignadas');
            $table->unsignedBigInteger('taller_id');
            $table->string('matricula');
            $table->enum('estado', ['presente', 'ausente', 'justificado'])->default('presente');
            $table->timestamps();
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
            $table->foreign('matricula')->references('matricula')->on('estudiantes')->onDelete('cascade');
        });

        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->string('matricula');
            $table->unsignedBigInteger('taller_id');
            $table->timestamps();            
            $table->foreign('matricula')->references('matricula')->on('estudiantes')->onDelete('cascade');
            $table->foreign('taller_id')->references('id')->on('talleres')->onDelete('cascade');
            $table->unique(['taller_id', 'matricula']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_talleres');
    }
};
