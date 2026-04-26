<?php

namespace App\Shared\Infrastructure\Framework\Laravel\Buses;

use App\Shared\Application\Contracts\Bus\QueryBus;
use Illuminate\Contracts\Foundation\Application;
use App\Shared\Application\Contracts\Queries\QueryContract;
/**
 * Implementación de un QueryBus utilizando el contenedor de servicios de Laravel.
 * Este bus se encarga de resolver y ejecutar los handlers correspondientes a cada query.
 *
 * El método `ask` recibe un objeto query, resuelve el handler correspondiente utilizando una convención de nombres
 * (reemplazando 'Query' por 'Handler' en el FQCN del query) y ejecuta su método `handle`, pasando el query como argumento.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Infrastructure\Framework\Laravel\Buses
 * @since 1.0.0
 * @version 1.0.0
 */
final class LaravelQueryBus implements QueryBus
{
    public function __construct(private readonly Application $app) {}

    public function ask(QueryContract $query): mixed
    {
        $handlerClass = $this->resolveHandlerClass($query);
        
        if (!class_exists($handlerClass)) {
            throw new \RuntimeException(
                "Handler {$handlerClass} no encontrado para el query " . get_class($query)
            );
        }
        $handler = $this->app->make($handlerClass);
        return $handler($query); // invocar el handler como un callable, asumiendo que implementa el método __invoke
    }

    private function resolveHandlerClass(QueryContract $query): string
    {
     // Clase del query   
    $queryClass = get_class($query);
    // posicion (ruta) de la clase
    $pos = strrpos($queryClass, '\\');
    $namespace = substr($queryClass, 0, $pos);
    $className = substr($queryClass, $pos + 1);
    $handlerClass = $namespace . '\Handlers\\' . str_replace('Query', 'Handler', $className);
    return $handlerClass;
    }
}