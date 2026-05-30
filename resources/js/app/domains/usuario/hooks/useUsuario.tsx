/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useFormNormal } from "@/app/shared/hooks"
import { type Usuario, UsuarioActions } from "../types/usuario.types"
import { FormMethods } from "@/app/shared/types/components"

/**
 * Hook personalizado para manejar la lógica CRUD de usuarios en administración.
 * Resuelve la acción correspondiente según el método HTTP y el ID del usuario,
 * utilizando las acciones definidas en UsuarioActions.
 * @param method - Método HTTP del formulario ('post', 'put', 'delete').
 * @param id - ID del usuario (requerido para put y delete).
 * @param data - Datos iniciales del formulario.
 * @returns form, submit, handleSubmit para el manejo del formulario.
 */
export default function useUsuario({
  method = 'post',
  id,
  data
}: {
  method?: keyof typeof FormMethods,
  id?: string | null
  data?: Usuario
}) {
  const action = (() => {
    const current = UsuarioActions[method]
    if (typeof current === 'function') {
      return id ? current(id) : ''
    }
    return current
  })()

  const { form, handleSubmit, submit } = useFormNormal<Usuario>({
    action,
    data: data ?? {} as Usuario,
    method
  })

  return {
    form,
    submit,
    handleSubmit
  }
}
