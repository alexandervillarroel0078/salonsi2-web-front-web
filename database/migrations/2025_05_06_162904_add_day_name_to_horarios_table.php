<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->string('day_name')->after('personal_id');
        });
    }


    public function down(): void
{
    Schema::table('horarios', function (Blueprint $table) {
        $table->dropColumn('day_name');
    });
}
};
