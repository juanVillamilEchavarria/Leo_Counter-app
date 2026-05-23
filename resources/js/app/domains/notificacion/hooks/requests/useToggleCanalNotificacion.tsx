import { router } from '@inertiajs/react'
import { NotificacionToggleActions, NotificacionToggleTypes } from '../../types/notificacion.types'

/**
 * Hook simple para alternar el estado activo de un canal de notificación.
 * Usa router.patch de Inertia para enviar la solicitud de toggle.
 * @returns {{ toggle: (id: string) => void }}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function useToggleCanalNotificacion() {
  const toggle = (id: string) => {
    router.patch(NotificacionToggleActions.toggleCanal(id, NotificacionToggleTypes.activo), {}, {
      preserveState: true,
      preserveScroll: true
    })
  }
  return { toggle }
}
