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
            $table->id();
            $table->string('nombre');
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('cuenta_id')->constrained('cuentas');
            $table->foreignId('movimiento_fijo_id')->nullable()->constrained('movimiento_fijos')->nullOnDelete();
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos');
            $table->decimal('monto', 12, 2);
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['pendiente', 'pagado', 'vencido'])->default('pendiente');
            $table->text('descripcion')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->string('url_pago')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // indices
            $table->index(['estado', 'fecha_vencimiento']);
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
