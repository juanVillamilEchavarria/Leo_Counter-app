<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Shared\Domain\ValueObjects;

use App\Shared\Domain\Exceptions\InvalidDomainArgumentException;

/**
 * Value object que representa un payload de JSON
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class JsonPayload
{
    private string $value;

    public function __construct(array $payload)
    {
        $json = json_encode($payload, JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            throw new InvalidDomainArgumentException('El payload proporcionado no pudo ser codificado a un JSON válido.');
        }

        $this->value = $json;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     *  recupera el array original
     */
    public function toArray(): array
    {
        return json_decode($this->value, true) ?? [];
    }


}
