<?php

// 1. Migration: database/migrations/xxxx_xx_xx_create_asistencias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personal_id');
            $table->date('fecha');
            $table->enum('estado', ['presente_local', 'presente_domicilio', 'ausente']);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('asistencias');
    }
};