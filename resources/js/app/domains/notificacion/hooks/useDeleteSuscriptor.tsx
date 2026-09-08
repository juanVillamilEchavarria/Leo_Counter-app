/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import { router } from "@inertiajs/react"
import { useDeleteSuscriptorNotificacion } from "./useDeleteSuscriptorNotificacion"

/**
 * Hook para eliminar un suscriptor de notificación.
 * Recupera el ID del suscriptor a eliminar y recarga la página tras el éxito.
 *
 * @param {string} id - ID del suscriptor a eliminar
 */
export default function useDeleteSuscriptor({
    id,
}: {
    id: string
}) {
    const { handleDelete, isPending } = useDeleteSuscriptorNotificacion()

    const handleDeleteForm = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault()
        handleDelete(id)
        router.reload({
            preserveUrl: true
        });
    }

    return {
        handleDelete: handleDeleteForm,
        isPending,
    }
}