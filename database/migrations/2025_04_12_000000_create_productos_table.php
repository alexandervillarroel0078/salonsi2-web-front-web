<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('categoria')->nullable(); // "Uñas", "Cabello", "Piel", etc.
            $table->string('tipo')->default('consumible'); // "consumible" o "equipo"
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(0); // Para alertas
            $table->string('unidad')->nullable(); // "unidad", "set", "ml", etc.
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
