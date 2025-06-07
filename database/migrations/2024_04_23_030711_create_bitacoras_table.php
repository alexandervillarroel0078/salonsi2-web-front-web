<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->string('accion', 100);
            $table->dateTime('fecha_hora');
            $table->bigInteger('id_operacion')->nullable();
            $table->string('ip', 20)->nullable();
            $table->timestamps();

            $table->string('usuario')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
