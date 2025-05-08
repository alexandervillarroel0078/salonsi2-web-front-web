<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->integer('duracion')->default(0);
            $table->decimal('precio_total', 8, 2)->default(0);
        });
    }
    
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn('duracion');
            $table->dropColumn('precio_total');
        });
    }
    
};
