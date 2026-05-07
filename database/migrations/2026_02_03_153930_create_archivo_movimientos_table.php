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
        Schema::create('archivo_movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('movimiento_id')->constrained('movimientos')->onDelete('cascade');
            $table->string('nombre_original');
            $table->string('nombre_guardado');
            $table->string('disk')->default('local');
            $table->string('path');
            $table->string('mime_type');
            $table->string('extension');
            $table->unsignedBigInteger('tamano_bytes');
            $table->text('notas')->nullable();
            $table->timestamps();
            // indices
            $table->index('movimiento_id');
            $table->index('created_at');
            $table->index(['movimiento_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivo_movimientos');
    }
};
