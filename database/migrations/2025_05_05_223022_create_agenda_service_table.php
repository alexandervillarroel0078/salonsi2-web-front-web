<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agenda_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('personal_id')->nullable()->constrained('personals')->nullOnDelete();
            $table->integer('cantidad')->default(1);

            $table->decimal('precio', 10, 2)->nullable();
            $table->decimal('comision_porcentaje', 5, 2)->nullable();


            $table->boolean('finalizado')->default(false);
            $table->tinyInteger('valoracion')->nullable(); // de 1 a 5
            $table->text('comentario')->nullable();

            $table->tinyInteger('valoracion_cliente')->nullable(); // lo llenará el cliente
            $table->text('comentario_cliente')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_service');
    }
};
