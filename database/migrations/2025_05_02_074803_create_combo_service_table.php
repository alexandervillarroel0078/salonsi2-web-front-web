<?php
// database/migrations/xxxx_xx_xx_create_combo_service_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComboServiceTable extends Migration
{
    public function up(): void
    {
        Schema::create('combo_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combo_id');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();

            // Relaciones
            $table->foreign('combo_id')->references('id')->on('combos')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            // Asegurarse de que las combinaciones sean únicas
            $table->unique(['combo_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('combo_service');
    }
}
