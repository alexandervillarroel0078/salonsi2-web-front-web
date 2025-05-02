<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('residentes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('apellido'); // ← importante
        $table->string('ci')->unique();
        $table->string('email')->unique();
        $table->string('tipo_residente'); // Ej: Propietario, Inquilino
        $table->boolean('estado')->default(true);
        $table->timestamps();
    });
    
}


    public function down(): void
    {
        Schema::dropIfExists('residentes');
    }
};
