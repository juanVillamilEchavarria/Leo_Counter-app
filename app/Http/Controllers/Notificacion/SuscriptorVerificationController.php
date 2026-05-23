<?php

namespace App\Http\Controllers\Notificacion;

use App\Application\Notificacion\Commands\VerifySuscriptorCommand;
use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Bus\CommandBus;

class SuscriptorVerificationController extends Controller
{
    public function __construct(
        private CommandBus $commandBus,
    )
    {
    }
    public function verify(string $suscriptorId){
        $this->commandBus->dispatch(new VerifySuscriptorCommand($suscriptorId));
        return view('notificaciones.suscriptores.verified');
    }

}
