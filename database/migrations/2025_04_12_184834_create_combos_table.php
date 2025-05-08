<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable(); // Nueva descripción
            $table->decimal('price', 8, 2);           // Precio normal del combo
            $table->decimal('discount_price', 8, 2)->nullable(); // Precio con descuento (opcional)
            $table->boolean('has_discount')->default(false);     // Indica si está en oferta
            $table->string('image_path')->nullable(); // Imagen representativa del combo
            $table->boolean('active')->default(true); // Estado del combo (activo/inactivo)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combos');
    }
};
