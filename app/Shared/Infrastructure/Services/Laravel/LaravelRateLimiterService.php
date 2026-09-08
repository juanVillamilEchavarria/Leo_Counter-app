<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Shared\Infrastructure\Services\Laravel;

use App\Shared\Application\DTOs\RateLimitResult;
use Carbon\CarbonInterval;
use Illuminate\Cache\RateLimiter;

/**
 * Servicio que encapsula la lógica de rate limiting usando el RateLimiter de Laravel.
 * Proporciona una API limpia y reutilizable para cualquier controller o caso de uso
 * que necesite limitar la frecuencia de operaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class LaravelRateLimiterService
{
    public function __construct(
        private RateLimiter $rateLimiter
    ) {}

    /**
     * Intenta adquirir un "permiso" de rate limit.
     * Si NO se ha superado el límite, incrementa el contador automáticamente.
     * Si YA se superó, retorna un resultado con el tiempo de espera restante.
     *
     * @param  string  $key  Identificador único del límite (ej: "login:{ip}:{email}")
     * @param  int  $maxAttempts  Máximo de intentos permitidos
     * @param  int  $decaySeconds  Tiempo en segundos antes de que expire el contador
     * @param  string  $locale  Locale para formatear el tiempo humano (default: 'es')
     */
    public function tryAcquire(
        string $key,
        int $maxAttempts,
        int $decaySeconds,
        string $locale = 'es'
    ): RateLimitResult {
        if ($this->rateLimiter->tooManyAttempts($key, $maxAttempts)) {
            return $this->buildBlockedResult($key, $maxAttempts, $locale);
        }

        $attempts = $this->rateLimiter->hit($key, $decaySeconds);
        $remaining = max(0, $maxAttempts - $attempts);

        return new RateLimitResult(
            allowed: true,
            attempts: $attempts,
            remaining: $remaining,
            retryAfterSeconds: 0,
            retryAfterHuman: '',
        );
    }

    /**
     * Registra un intento (incrementa el contador).
     *
     * @param  string  $key  Identificador único del límite
     * @param  int  $decaySeconds  Tiempo en segundos antes de que expire el contador
     */
    public function hit(string $key, int $decaySeconds): int
    {
        return $this->rateLimiter->hit($key, $decaySeconds);
    }

    /**
     * Limpia el contador de intentos para una key.
     */
    public function clear(string $key): void
    {
        $this->rateLimiter->clear($key);
    }

    /**
     * Obtiene el número de intentos actuales para una key.
     */
    public function attempts(string $key): int
    {
        return $this->rateLimiter->attempts($key);
    }

    /**
     * Obtiene los intentos restantes antes de bloquear.
     */
    public function remaining(string $key, int $maxAttempts): int
    {
        return $this->rateLimiter->remaining($key, $maxAttempts);
    }

    /**
     * Obtiene los segundos restantes hasta que se libere el bloqueo.
     */
    public function availableIn(string $key): int
    {
        return $this->rateLimiter->availableIn($key);
    }

    /**
     * Verifica si se han superado los intentos (sin incrementarlos).
     */
    public function tooManyAttempts(string $key, int $maxAttempts): bool
    {
        return $this->rateLimiter->tooManyAttempts($key, $maxAttempts);
    }

    /**
     * Construye un RateLimitResult para el caso de bloqueo.
     */
    private function buildBlockedResult(
        string $key,
        int $maxAttempts,
        string $locale
    ): RateLimitResult {
        $retryAfterSeconds = $this->rateLimiter->availableIn($key);

        $retryAfterHuman = CarbonInterval::seconds($retryAfterSeconds)
            ->cascade()
            ->forHumans([
                'parts' => 2,
                'short' => true,
                'locale' => $locale,
            ]);

        return new RateLimitResult(
            allowed: false,
            attempts: $this->rateLimiter->attempts($key),
            remaining: 0,
            retryAfterSeconds: $retryAfterSeconds,
            retryAfterHuman: $retryAfterHuman,
        );
    }
}
