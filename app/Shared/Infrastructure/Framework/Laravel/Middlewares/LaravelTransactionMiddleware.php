<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Framework\Laravel\Middlewares;


use Closure;
use Illuminate\Support\Facades\DB;
use App\Shared\Application\Contracts\Commands\TransactionalCommandContract;

/**
 * middleware que envuelve el comando en un transaction
 * @package App\Shared\Infrastructure\Framework\Laravel\Middlewares
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelTransactionMiddleware
{
    public function handle(object $command, Closure $next): mixed
    {
        if ($command instanceof TransactionalCommandContract) {
            return DB::transaction(fn() => $next($command));
        }
        return $next($command);
    }
}
