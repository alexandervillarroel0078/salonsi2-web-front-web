<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personal_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('available')->default(true);
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
}
