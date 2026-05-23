
import Button from "@/app/shared/components/common/Button";

export interface VerificationSuccessProps {
    userName: string;
    onClose: () => void;
}

/**
 * Muestra el estado de verificación exitosa con botón OK para cerrar.
 */
export default function VerificationSuccess({ userName, onClose }: VerificationSuccessProps) {
    return (
        <div className="flex flex-col items-center gap-4 py-8 text-center">
                <i className="fas fa-check-circle text-4xl text-green-500" />
                <p className="text-lg font-semibold">¡Suscripción verificada!</p>
            <p className="text-sm text-muted-foreground">
                El usuario <strong>{userName}</strong> ahora recibirá notificaciones.
            </p>
            <Button variant="secondary" onClick={onClose}>
                OK
                </Button>
        </div>
);
}
