<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');        // Nombre de la promoción
            $table->text('description')->nullable(); // Opcional
            $table->integer('discount_percentage')->nullable();
            $table->date('start_date');     // Desde cuándo empieza
            $table->date('end_date');       // Hasta cuándo es válida
            $table->boolean('active')->default(true); // Activa o no
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
