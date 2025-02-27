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
        Schema::create('gimnasios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_gim');
            $table->text('descripcion')->nullable();
            $table->string('horario')->nullable();
            $table->integer('num_alumnos')->default(0);
            $table->string('enlace_grupo')->nullable();
            $table->string('emp_docente_1')->nullable();
            $table->foreign('emp_docente_1')->references('matricula')->on('docentes')->onDelete('set null');
            $table->string('emp_docente_2')->nullable();
            $table->foreign('emp_docente_2')->references('matricula')->on('docentes')->onDelete('set null');
            $table->string('emp_docente_3')->nullable();
            $table->foreign('emp_docente_3')->references('matricula')->on('docentes')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('talleres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tall');
            $table->text('descripcion')->nullable();
            $table->string('horario')->nullable();;
            $table->integer('num_alumnos')->default(0);
            $table->string('enlace_grupo')->nullable();
            $table->string('emp_docente')->nullable();;
            $table->foreign('emp_docente')->references('matricula')->on('docentes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gimnasios');
        Schema::dropIfExists('talleres');
    }
};
