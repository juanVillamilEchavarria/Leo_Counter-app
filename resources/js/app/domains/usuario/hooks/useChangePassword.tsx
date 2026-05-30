/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'
import { PasswordActions, type UsuarioPasswordData } from '../types/usuario.types'
import useFormNormal from '@/app/shared/hooks/form/useFormNormal';

/**
 * Hook personalizado para manejar la lógica de cambio de contraseña del usuario, utilizando el sistema de formularios de Inertia.js y las rutas y acciones definidas en PasswordActions.
 * @param param0 
 * @returns 
 */
export default function useChangePassword({
    data
}: {
    data?: UsuarioPasswordData
}) {
  const { form, submit, handleSubmit } = useFormNormal({
       action: PasswordActions.update,
       method: 'put',
       data
     });
   
     return {
       form,
       submit,
       handleSubmit
     }
}
