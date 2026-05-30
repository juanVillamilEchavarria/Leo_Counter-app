/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { router } from "@inertiajs/react"
import { useSuscriptorMutation } from "./api/useSuscriptorMutation"
import { toastHelper } from "@/app/shared/helpers"


/**
 * Hook para eliminar un suscriptor de notificación
 * 
 * 
 * @param {string} id  - ID del suscriptor a eliminar
 * @returns 
 */
export default function useDeleteSuscriptor({
    id
}:{
    id: string
}) {
  const {mutate} = useSuscriptorMutation({
    action: 'delete',
    id,
    onSuccess: () => {
        toastHelper.success('Suscriptor eliminado')
        router.reload({
               preserveUrl: true
            });
    },
    onError: (err) => {
        toastHelper.error('Error al eliminar suscriptor')
    }
  })

  const handleDelete = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault()
    mutate()
  }

  return {
    handleDelete
  }
}
