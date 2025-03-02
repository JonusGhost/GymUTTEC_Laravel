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
        Schema::create('users', function (Blueprint $table)
        {
            $table->string('matricula')->primary();
            $table->string('rol',1)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        
        Schema::create('administradores', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->foreign('matricula')->references('matricula')->on('users')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido_pat');
            $table->string('apellido_mat');
            $table->string('num_celular');
            $table->string('afili_seguro');
            $table->timestamps();
        });

        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->foreign('matricula')->references('matricula')->on('users')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido_pat');
            $table->string('apellido_mat');
            $table->string('num_celular');
            $table->string('afili_seguro');
            $table->string('especialidad');
            $table->timestamps();
        });

        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('matricula')->unique();
            $table->foreign('matricula')->references('matricula')->on('users')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido_pat');
            $table->string('apellido_mat');
            $table->string('num_celular');
            $table->string('afili_seguro');
            $table->string('grado');
            $table->string('sit_academica');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('administradores');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('estudiantes');
    }
};