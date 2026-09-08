<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Shared\Infrastructure\Framework\Laravel\Middlewares;

use App\Shared\Domain\Exceptions\TooManyRequestsException;
use App\Shared\Infrastructure\Framework\Laravel\Middlewares\Enums\RateLimitType;
use App\Shared\Infrastructure\Services\Laravel\LaravelRateLimiterService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de rate limiting personalizado.
 * Usa el LaravelRateLimiterService para validar intentos y lanza
 * TooManyRequestsException si se supera el límite.
 *
 * Uso en rutas:
 *   Route::middleware(['rate.limit:5,2'])->post('/login', ...);
 *   Route::middleware(['rate.limit:5,2,email'])->post('/login', ...);
 *   Route::middleware(['rate.limit:5,2,ip_email'])->post('/login', ...);
 *
 * Parámetros:
 *   - maxAttempts (int): máximo de intentos permitidos
 *   - decayMinutes (int): ventana de tiempo en minutos
 *   - strategy (string, opcional): estrategia de key (default: 'user')
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class RateLimitMiddleware
{
    public function __construct(
        private LaravelRateLimiterService $rateLimiter,
    ) {}

    public function handle(Request $request, Closure $next, int $maxAttempts, int $decayMinutes, string $strategyName = 'user'): Response
    {
        $strategy = $this->resolveStrategy($strategyName);
        $key = $this->buildKey($request, $strategy);
        $decaySeconds = $decayMinutes * 60;

        $result = $this->rateLimiter->tryAcquire(
            key: $key,
            maxAttempts: $maxAttempts,
            decaySeconds: $decaySeconds,
        );

        if (! $result->allowed) {
            throw new TooManyRequestsException(
                retryAfterSeconds: $result->retryAfterSeconds,
                retryAfterHuman: $result->retryAfterHuman,
                message: "Demasiadas solicitudes. Intenta de nuevo en {$result->retryAfterHuman}.",
            );
        }

        return $next($request);
    }

    private function resolveStrategy(string $strategyName): RateLimitType
    {
        return RateLimitType::tryFrom($strategyName)
            ?? throw new \InvalidArgumentException("Estrategia de rate limit desconocida: {$strategyName}");
    }

    private function buildKey(Request $request, RateLimitType $strategy): string
    {
        $prefix = 'rate_limit';

        $identifier = match ($strategy) {
            RateLimitType::USER_OR_IP => $request->user()?->id ?? $request->ip(),
            RateLimitType::IP => $request->ip(),
            RateLimitType::EMAIL => $request->input('email', $request->ip()),
            RateLimitType::IP_AND_EMAIL => $request->ip().'|'.$request->input('email', ''),
            RateLimitType::USER => $request->user()?->id
                ?? throw new \LogicException('La estrategia "user_strict" requiere un usuario autenticado'),
        };

        return "{$prefix}:{$strategy->value}:{$identifier}";
    }
}
