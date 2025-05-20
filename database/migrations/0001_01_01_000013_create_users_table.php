<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Relaciones opcionales
           $table->foreignId('personal_id')->nullable()->constrained('personals')->onDelete('cascade');
             $table->foreignId('residente_id')->nullable()->constrained('residentes')->onDelete('cascade');
            
            $table->rememberToken();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
