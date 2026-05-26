import { useFormNormal } from "@/app/shared/hooks"
import { UsuarioActions, type UsuarioChangePasswordData } from "../types/usuario.types"

/**
 * Hook personalizado para manejar la lógica de cambio de contraseña de un usuario
 * desde el módulo de administración. A diferencia de useChangePassword (perfil propio),
 * este hook no requiere el campo current_password.
 * @param id - ID del usuario al que se le cambia la contraseña.
 * @param data - Datos iniciales del formulario (password, password_confirmation).
 * @returns form, submit, handleSubmit para el manejo del formulario.
 */
export default function useUsuarioChangePassword({
  id,
  data
}: {
  id: string
  data?: UsuarioChangePasswordData
}) {
  const { form, submit, handleSubmit } = useFormNormal<UsuarioChangePasswordData>({
    action: UsuarioActions.changePassword(id),
    method: 'put',
    data: data ?? { password: '', password_confirmation: '' }
  })

  return {
    form,
    submit,
    handleSubmit
  }
}
