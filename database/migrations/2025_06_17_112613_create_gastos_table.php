<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->string('detalle');
            $table->decimal('monto', 10, 2);
            $table->date('fecha');

            $table->foreignId('categoria_gasto_id')->constrained('categorias_gasto')->onDelete('restrict');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('agenda_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
