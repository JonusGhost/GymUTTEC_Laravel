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
            $table->string('horario');
            $table->integer('num_alumnos')->default(0);
            $table->string('enlace_grupo')->nullable();

            $table->string('emp_docente_1');
            $table->foreign('emp_docente_1')->references('num_empleado')->on('user_docentes')->onDelete('set null');
            $table->string('emp_docente_2');
            $table->foreign('emp_docente_2')->references('num_empleado')->on('user_docentes')->onDelete('set null');
            $table->string('emp_docente_3');
            $table->foreign('emp_docente_3')->references('num_empleado')->on('user_docentes')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('talleres', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tall');
            $table->text('descripcion')->nullable();
            $table->string('horario');
            $table->integer('num_alumnos')->default(0);
            $table->string('enlace_grupo')->nullable();
            $table->string('emp_docente');
            $table->foreign('emp_docente')->references('num_empleado')->on('user_docentes')->onDelete('set null');
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
