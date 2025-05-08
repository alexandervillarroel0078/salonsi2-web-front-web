<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();       // 🆕 descripción del servicio
            $table->string('category')->nullable();        // 🆕 categoría (cabello, facial, etc.)
            $table->string('image_path')->nullable();
            $table->double('price')->default(0);
            $table->double('discount_price')->default(0);
            $table->integer('duration_minutes')->nullable(); // 🆕 duración estimada
            $table->boolean('has_discount')->default(false);
            $table->boolean('has_available')->default(true); // 🆕 disponibilidad (opcional)
            $table->enum('tipo_atencion', ['salon', 'domicilio'])->default('salon');
            $table->unsignedBigInteger('specialist_id')->nullable(); // 🆕 relación futura
            $table->timestamps();
            // Si quieres mantener integridad con `personals`, descomenta esto:
            // $table->foreign('specialist_id')->references('id')->on('personals')->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
