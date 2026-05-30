/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'
import { ProfileActions, ProfileRoutes, type UsuarioData } from '../types/usuario.types'
import { useForm } from '@inertiajs/react'
import useFormNormal from '@/app/shared/hooks/form/useFormNormal';

/**
 * 
 * Hook personalizado para manejar la lógica de actualización del perfil de usuario, utilizando el sistema de formularios de Inertia.js y las rutas y acciones definidas en ProfileActions y ProfileRoutes.
 * @param data - Datos iniciales del usuario para llenar el formulario, opcional. 
 * @returns 
 */
export default function useProfile({
    data
}:{
    data?: UsuarioData
}) {
   const { form, submit, handleSubmit } = useFormNormal({
      action: ProfileActions.update,
      method: 'put',
      data
    });
  
    return {
      form,
      submit,
      handleSubmit
    }
}
