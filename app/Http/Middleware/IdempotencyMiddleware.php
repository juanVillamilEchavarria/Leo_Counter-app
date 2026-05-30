<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

final readonly class IdempotencyMiddleware
{
    private const HEADER_KEY = 'Idempotency-Key';
    private const CACHE_PREFIX = 'idempotency:';
    private const TTL_SECONDS = 86400;

    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $next($request);
        }

        $key = $request->header(self::HEADER_KEY);
        if (!$key) {
            return $next($request);
        }

        $cacheKey = self::CACHE_PREFIX . $key;

        // adquirimos un bloqueo atomico por 10 segundos para evitar otro request idéntico
        $lock = Cache::lock($cacheKey . ':lock', 10);

        if (!$lock->get()) {
            // Si no se puede adquirir el bloqueo, es porque hay otra petición idéntica procesándose en paralelo
            return response()->json([
                'error' => 'Conflict',
                'message' => 'Una petición idéntica ya está siendo procesada.'
            ], Response::HTTP_CONFLICT);
        }

        try {
            if (Cache::has($cacheKey)) {
                $cached = Cache::get($cacheKey);
                return new Response(
                    $cached['content'],
                    $cached['status'],
                    $cached['headers']
                );
            }

            // Procesar la petición original
            $response = $next($request);

            if ($response->isSuccessful() || $response->isRedirection()) {
                Cache::put($cacheKey, [
                    'content' => $response->getContent(),
                    'status'  => $response->getStatusCode(),
                    'headers' => $response->headers->all(),
                ], self::TTL_SECONDS);
            }

            return $response;

        }
        finally {
        $lock->release();
    }
    }
}
