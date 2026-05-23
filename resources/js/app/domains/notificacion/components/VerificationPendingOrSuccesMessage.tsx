
import VerificationPending from './VerificationPending'
import VerificationSuccess from './VerificationSuccess'

interface VerificationPendingOrSuccesMessageProps {
    userName: string,
    channelName: string,
    verified: boolean,
    handleClose: () => void
}
/**
 * Componente que muestra un mensaje de verificación pendiente o éxito según el estado de verificación del suscriptor.
 * Se utiliza en el modal de creación de suscriptor para mostrar el estado de la verificación después de enviar el formulario.
 * @param param0 
 * @returns 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 * @param param0 
 * @returns 
 */
export default function VerificationPendingOrSuccesMessage({
    userName,
    channelName,
    verified,
    handleClose
}: VerificationPendingOrSuccesMessageProps 
) {
  return !verified ? (
        <VerificationPending userName={userName} channelName={channelName}/>
    ) : (
        <VerificationSuccess userName={userName} onClose={handleClose}/>
    )
}
