<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suscriptores_notificaciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('canal_notificacion_id')->constrained('canales_notificacion');
            $table->boolean('active')->default(true);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id','canal_notificacion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suscriptores_notificaciones');
    }
};
