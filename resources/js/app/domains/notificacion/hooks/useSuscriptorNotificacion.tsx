import { useFormNormal } from "@/app/shared/hooks"
import { type SuscriptorNotificacion, SuscriptorNotificacionActions } from "../types/notificacion.types"
import { FormMethods } from "@/app/shared/types/components"

/**
 * Hook para manejar formularios de Suscriptor de Notificación (create/update/delete).
 * Sigue el patrón exacto de useCuenta y useCategoria:
 * resuelve la acción según el método y el id, y delega en useFormNormal.
 * @param {object} params - Parámetros del hook
 * @param {string} params.method - Método HTTP: 'post' | 'put' | 'patch' | 'delete'
 * @param {string | null} params.id - ID del suscriptor (requerido para put/patch/delete)
 * @param {SuscriptorNotificacion} params.data - Datos iniciales del formulario
 * @returns {object} { form, submit, handleSubmit }
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function useSuscriptorNotificacion({
  method = 'post',
  id,
  data
}: {
  method?: keyof typeof FormMethods
  id?: string | null
  data?: SuscriptorNotificacion
}) {
  const action = (() => {
    const current = SuscriptorNotificacionActions[method]
    if (typeof current === 'function') {
      return id ? current(id) : ''
    }
    return current
  })()

  const { form, submit, handleSubmit } = useFormNormal<SuscriptorNotificacion>({
    action,
    data: data ?? {} as SuscriptorNotificacion,
    method
  })

  return {
    form,
    submit,
    handleSubmit
  }
}
