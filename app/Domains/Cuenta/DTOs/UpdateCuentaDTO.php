<?php
namespace App\Domains\Cuenta\DTOs;

class UpdateCuentaDTO {
    public function __construct(
        public readonly string $propietario_id,
        public readonly string $tipo_cuenta_id,
        public readonly string $nombre,
        public readonly string $saldo_inicial,
        public readonly ?string $notas
    ){}

    public function toArray(){
        return [
            'propietario_id' => $this->propietario_id,
            'tipo_cuenta_id' => $this->tipo_cuenta_id,
            'nombre' => $this->nombre,
            'saldo_inicial' => $this->saldo_inicial,
            'notas' => $this->notas
        ];
    }
}