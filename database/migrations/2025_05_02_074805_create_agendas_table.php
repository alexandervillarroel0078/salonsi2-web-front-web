<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('personal_id')->nullable()->constrained()->onDelete('set null');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('tipo_atencion', ['salon', 'domicilio']);
            $table->string('ubicacion'); // 🔹 Campo agregado
            $table->enum('estado', ['pendiente', 'confirmada', 'en_curso', 'finalizada', 'cancelada'])
                ->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
