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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('cuenta_id')->constrained('cuentas')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos')->onDelete('cascade');
            $table->foreignId('movimiento_pendiente_id')->nullable()->constrained('movimiento_pendientes')->nullOnDelete();
            $table->decimal('monto', 12, 2);
            $table->date('fecha');
            $table->text('descripcion')->nullable();
            $table->softDeletes();
            $table->timestamps();
            // indices
            $table->index(['cuenta_id', 'categoria_id', 'tipo_movimiento_id'], 'movimiento_index');
            $table->index(['fecha', 'categoria_id']);
            $table->index(['fecha', 'tipo_movimiento_id']);
            $table->index(['movimiento_pendiente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
