<?php

namespace App\Application\Auth\Commands\Handlers;

use App\Application\Auth\Commands\SendPasswordResetLinkCommand;
use App\Application\Usuario\Exceptions\CannotChangeAdminPasswordException;
use App\Domains\Auth\Contracts\Services\PasswordResetTokenServiceContract;
use App\Domains\Auth\Events\PasswordResetLinkRequested;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;

/**
 * Handler del caso de uso para solicitar un enlace de restablecimiento de contraseña.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Auth\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendPasswordResetLinkHandler
{
    /**
     * @param PasswordResetTokenServiceContract $tokenService Servicio de tokens de restablecimiento.
     * @param EventBus $eventBus Bus de eventos de dominio.
     */
    public function __construct(
        private PasswordResetTokenServiceContract $tokenService,
        private EventBus $eventBus,
        private UsuarioRepositoryContract $usuarioRepository
    ) {
    }

    /**
     * Ejecuta la solicitud de enlace. Si el email no existe, finaliza sin publicar evento para no revelar usuarios.
     *
     * @param SendPasswordResetLinkCommand $command Comando de solicitud.
     * @return void
     */
    public function __invoke(SendPasswordResetLinkCommand $command): void
    {
        $usuario = $this->usuarioRepository->findByEmail(new Email($command->email));
        if(!$usuario){
            throw new CannotFindUsuarioException('No se encontro un usuario para el email :'. $command->email);
        }
        try {
            $token = $this->tokenService->createToken($command->email);
        } catch (\Throwable $e) {
            throw new CannotChangeAdminPasswordException('No se pudo crear el token de restablecimiento de contraseña: '.$e->getMessage());
        }

        $this->eventBus->publish(new PasswordResetLinkRequested($usuario, $token));
    }
}
