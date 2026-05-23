export interface VerificationPendingProps {
    userName: string;
    channelName: string;
}

/**
 * Muestra el estado de espera mientras el usuario confirma el enlace de verificación.
 */
export default function VerificationPending({ userName, channelName }: VerificationPendingProps) {
    return (
        <div className="flex flex-col items-center gap-4 py-8 text-center">
            <i className="fas fa-spinner fa-spin text-3xl text-blue-500" />
            <p className="text-sm text-muted-foreground">
                Hemos enviado un enlace de verificación al canal <strong>{channelName}</strong> para <strong>{userName}</strong>.
                <br />
                Por favor, revisa tu bandeja de entrada y haz clic en el enlace para confirmar la suscripción.
            </p>
        </div>
    );
}
