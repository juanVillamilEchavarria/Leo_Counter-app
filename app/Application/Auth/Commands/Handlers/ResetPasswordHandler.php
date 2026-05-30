<?php

namespace App\Application\Auth\Commands\Handlers;

use App\Application\Auth\Commands\ResetPasswordCommand;
use App\Application\Auth\Exceptions\InvalidPasswordResetTokenException;
use App\Application\Usuario\Exceptions\CannotFindUsuarioException;
use App\Domains\Auth\Contracts\Services\PasswordResetTokenServiceContract;
use App\Domains\Auth\Events\PasswordResetSucceeded;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Password;

/**
 * Handler del caso de uso para restablecer una contraseña mediante token.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Auth\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ResetPasswordHandler
{
    /**
     * @param PasswordResetTokenServiceContract $tokenService Servicio de tokens.
     * @param UsuarioRepositoryContract $usuarioRepository Repositorio de usuarios.
     * @param EventBus $eventBus Bus de eventos de dominio.
     */
    public function __construct(
        private PasswordResetTokenServiceContract $tokenService,
        private UsuarioRepositoryContract $usuarioRepository,
        private EventBus $eventBus
    ) {
    }

    /**
     * Valida el token, actualiza la contraseña, elimina el token y publica el evento de exito.
     *
     * @param ResetPasswordCommand $command Comando de restablecimiento.
     * @return bool Resultado de la actualizacion.
     */
    public function __invoke(ResetPasswordCommand $command): void
    {
        if (!$this->tokenService->validateToken($command->email, $command->token)) {
            throw new InvalidPasswordResetTokenException('El token de restablecimiento no es valido o expiro.');
        }

        /** @var Usuario|null $usuario */
        $usuario = $this->usuarioRepository->findByEmail(new Email($command->email));

        if (!$usuario) {
            throw new CannotFindUsuarioException();
        }

        $usuario = $usuario->changePassword(Password::create($command->password));
        $updated = $this->usuarioRepository->update($usuario);
            $this->tokenService->deleteToken($command->email);
            $this->eventBus->publish(new PasswordResetSucceeded($command->email));

    }
}
