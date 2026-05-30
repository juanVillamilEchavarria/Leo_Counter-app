<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movimiento_fijos', function (Blueprint $table) {
            $table->unsignedTinyInteger('dias_aviso')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimiento_fijos', function (Blueprint $table) {
            $table->dropColumn('dias_aviso');
        });
    }
};
