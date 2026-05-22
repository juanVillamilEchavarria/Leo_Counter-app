<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canales_notificacion', function (Blueprint $table) {
            if (Schema::hasColumn('canales_notificacion', 'configuracion')) {
                $table->dropColumn('configuracion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('canales_notificacion', function (Blueprint $table) {
            $table->json('configuracion')->nullable();
        });
    }
};
