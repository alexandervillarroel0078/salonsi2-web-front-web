<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->decimal('monto', 10, 2);
            $table->string('estado'); 
            $table->string('metodo_pago')->nullable();
            $table->timestamps();

            $table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
