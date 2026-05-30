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
            $table->uuid('id')->primary();
            $table->foreignUuid('categoria_id')->constrained('categorias');
            $table->date('periodo');
            $table->decimal('monto', 15, 2);
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('descripcion')->nullable();
            $table->softDeletes();
            $table->timestamps();
             
            // uniques
            $table->unique([
                'categoria_id',
                'periodo'
            ], 'presupuestos_categoria_fecha_unique');

            // indices
            $table->index('categoria_id');
            $table->index('user_id');
            $table->index(['categoria_id', 'periodo'], 'presupuestos_categoria_fecha_index');


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
