<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->date('fecha');
            $table->time('hora');
            $table->enum('tipo_atencion', ['salon', 'domicilio']);
            $table->string('ubicacion')->nullable();
            $table->enum('estado', ['pendiente', 'confirmada', 'en_curso','por_confirmar', 'finalizada', 'cancelada'])->default('pendiente');
            $table->text('notas')->nullable();
            $table->integer('duracion')->default(0);
            $table->decimal('precio_total', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
