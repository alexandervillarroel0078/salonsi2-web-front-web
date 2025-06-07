<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('activo')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('personal_id')->nullable()->constrained('personals')->onDelete('cascade');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
