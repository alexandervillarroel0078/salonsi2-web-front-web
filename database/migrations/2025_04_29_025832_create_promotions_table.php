<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla para la promoción
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('discount_percentage', 5, 2); // Descuento en porcentaje
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('active')->default(true); // Activa o no la promoción
            $table->timestamps();
        });

        // Agregar un campo 'promotion_id' en los servicios
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('promotion_id')->nullable();  // Relaciona la promoción con el servicio
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->dropColumn('promotion_id');
        });
        Schema::dropIfExists('promotions');
    }
};

