<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('photo_url')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->boolean('status')->default(true);

            $table->foreignId('cargo_personal_id')->nullable()->constrained('cargo_personals')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
