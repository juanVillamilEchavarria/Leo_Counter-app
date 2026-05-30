/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import type { InertiaForm } from "node_modules/@inertiajs/react/types/useForm"
import { useCallback } from "react"
import type { CanalNotificacion, SuscriptorFormData, SuscriptorNotificacionFormOptions } from "../types/notificacion.types"
import type { UsuarioForForm } from "../../user/types/user.types"
import { type SuscriptorApiAction } from "../types/notificacion.types"
  
  export const selectedUser =(form : InertiaForm<SuscriptorFormData>, options: SuscriptorNotificacionFormOptions) : UsuarioForForm | undefined | null => {
    if (!form.data.user_id || !options?.usuarios) return null
    return options.usuarios.find(u => u.id === form.data.user_id)
  }

  export const selectedChannel =(form: InertiaForm<SuscriptorFormData>, options: SuscriptorNotificacionFormOptions) : CanalNotificacion | undefined | null => {
    if (!form.data.canal_notificacion_id || !options?.canales) return null
    return options.canales.find(c => c.id === form.data.canal_notificacion_id)
  }
  export function shouldVerify(
    action: SuscriptorApiAction,
    currentUserId: string,
    currentCanalId: string,
    originalUserId?: string | null,
    originalCanalId?: string | null
): boolean {
    if (action === 'create') return true;
    return currentUserId !== originalUserId || currentCanalId !== originalCanalId;
}