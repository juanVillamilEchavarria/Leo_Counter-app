<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Http\Controllers\Transferencia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transferencia\StoreTransferenciaRequest;
use App\Application\Transferencia\Commands\StoreTransferenciaCommand;
use Illuminate\Contracts\Bus\Dispatcher;
use Inertia\Inertia;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;

/**
 * Controlador para gestionar las transferencias.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
class TransferenciaController extends Controller
{
    public function __construct(
        private Dispatcher $dispatcher,
        private ListCuentaForFormContract $listCuentaForFormContract
    ) {
    }

    public function index()
    {

        return Inertia::render('Transferencias/Index', [
            'title' => 'Transferencias',
            'cuentas' => $this->listCuentaForFormContract->execute(),
        ]);
    }

    public function store(StoreTransferenciaRequest $request)
    {
        $this->dispatcher->dispatch(
            new StoreTransferenciaCommand(
                cuenta_origen_id: $request->cuenta_origen_id,
                cuenta_destino_id: $request->cuenta_destino_id,
                monto: (float) $request->monto,
                descripcion: $request->descripcion
            )
        );

        Inertia::flash('success', 'Transferencia creada correctamente');
        return redirect()->route('transferencias.index');
    }
}
