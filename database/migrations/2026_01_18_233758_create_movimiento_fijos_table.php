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
        Schema::create('movimiento_fijos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos');
            $table->foreignUuid('categoria_id')->constrained('categorias');
            $table->foreignUuid('cuenta_id')->constrained('cuentas');
            $table->foreignId('frecuencia_movimiento_id')->constrained('frecuencia_movimientos');
            $table->decimal('monto', 18, 2);
            $table->date('fecha_proximo');
            $table->boolean('active')->default(true);
            $table->boolean('registrar_automatico')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['tipo_movimiento_id', 'categoria_id', 'cuenta_id', 'frecuencia_movimiento_id'], 'movimiento_fijo_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_fijos');
    }
};
