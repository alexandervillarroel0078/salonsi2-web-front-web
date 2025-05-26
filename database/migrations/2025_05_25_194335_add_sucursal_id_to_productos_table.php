<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->unsignedBigInteger('sucursal_id')->nullable()->after('id');
        $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropForeign(['sucursal_id']);
        $table->dropColumn('sucursal_id');
    });
}

};
