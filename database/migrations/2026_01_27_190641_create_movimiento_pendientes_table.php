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
        Schema::create('movimiento_pendientes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->foreignUuid('categoria_id')->constrained('categorias');
            $table->foreignUuid('cuenta_id')->constrained('cuentas');
            $table->foreignUuid('movimiento_fijo_id')->nullable()->constrained('movimiento_fijos')->nullOnDelete();
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos');
            $table->decimal('monto', 12, 2);
            $table->date('fecha_programada');
            $table->enum('estado', ['pendiente', 'realizado', 'vencido'])->default('pendiente');
            $table->unsignedTinyInteger('dias_aviso')->nullable()->default(0);
            $table->text('descripcion')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // indices
            $table->index(['estado', 'fecha_programada']);
            $table->index(['movimiento_fijo_id']);
            $table->index(['categoria_id', 'cuenta_id', 'tipo_movimiento_id'], 'movimiento_pendiente_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_pendientes');
    }
};
