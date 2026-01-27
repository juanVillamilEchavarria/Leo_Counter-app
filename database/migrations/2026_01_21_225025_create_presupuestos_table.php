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
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->decimal('monto', 12, 2);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('tipo_presupuesto_id')
                ->constrained('tipo_presupuestos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->text('descripcion')->nullable();
            $table->softDeletes();
            $table->timestamps();
             
            // uniques
            $table->unique([
                'categoria_id',
                'fecha_inicio',
                'fecha_final',
                'tipo_presupuesto_id',
                'deleted_at'
            ], 'presupuestos_categoria_fecha_tipo_unique');

            // indices
            $table->index('categoria_id');
            $table->index('user_id');
            $table->index('tipo_presupuesto_id');
            $table->index(['categoria_id', 'fecha_inicio', 'fecha_final', 'tipo_presupuesto_id'], 'presupuestos_categoria_fecha_tipo_index');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
