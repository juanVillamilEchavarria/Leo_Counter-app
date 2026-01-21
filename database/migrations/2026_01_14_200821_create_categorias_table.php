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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('tipo_movimiento_id')->constrained('tipo_movimientos')->onDelete('cascade');
            $table->boolean('es_fijo')->default(false); // este no hace referencia a si el monto es fijo, sino a si es una categoria fija (ej: alquiler) o algo que sea siempre el mismo cada x tiempo
            $table->text('descripcion')->nullable();   
            $table->boolean('is_system')->default(false); 
            $table->softDeletes();
            $table->timestamps();
            //indices
            $table->index('tipo_movimiento_id');

            //uniques
            $table->unique(['nombre', 'tipo_movimiento_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
