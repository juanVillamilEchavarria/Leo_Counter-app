import { type AlertMessageProps } from "../../types/components"
/**
 * Componente de mensaje de alerta para mostrar mensajes de error o éxito en los formularios
 * @param {string} message - Mensaje de alerta a mostrar
 * @param {'error' | 'success'} type - Tipo de mensaje, puede ser 'error' o 'success', por defecto es 'error' 
 * @returns {JSX.Element} Componente de mensaje de alerta
 * @example
 * <AlertMessage type="error" message="Este es un mensaje de error" />
 * <AlertMessage type="success" message="Este es un mensaje de éxito" />
 */
export default function AlertMessage({
    message,
    type = 'error'
}:AlertMessageProps) {
    const BaseStyles= `p-2 border-l-4 rounded-lg transition-all duration-300 ease-out
        animate-fade-in
      ${type === 'success' ? 'bg-green-300 border-green-800' : 'bg-red-300 border-red-800'}
    `
    return (
        <div className={BaseStyles}>
            <p className="text-sm">{message}</p>
        </div>
    )
}
