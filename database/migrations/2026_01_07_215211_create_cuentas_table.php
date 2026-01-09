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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('saldo_inicial', 12, 2);
            $table->decimal('saldo_actual', 12, 2)->default(0);
            $table->foreignId('tipo_cuenta_id')->constrained('tipo_cuentas');
            $table->foreignId('propietario_id')->constrained('propietarios');
            $table->text('notas')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            // indices
            $table->index('tipo_cuenta_id');
            $table->index('propietario_id');
            $table->index('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
