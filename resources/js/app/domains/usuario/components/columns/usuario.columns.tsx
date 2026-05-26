import { type Usuario, UsuarioRoutes } from "../../types/usuario.types"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import type { SimpleTableColumn } from "@/app/shared/types/components"

/**
 * Columnas estáticas de la tabla de usuarios (sin acciones).
 */
export const UsuarioStaticColumns: SimpleTableColumn<Usuario>[] = [
    { key: "name", label: "Nombre" },
    { key: "email", label: "E-mail" },
    { key: "role", label: "Rol" },
]

/**
 * Retorna las columnas completas de la tabla de usuarios, incluyendo acciones de edición y eliminación.
 * @param onSelect - Callback que se ejecuta al seleccionar un usuario para eliminación.
 * @returns Array de columnas para SimpleTable.
 */
export const UsuarioColumns = ({
    onSelect,
}: {
    onSelect: (usuario: Usuario) => void
}): SimpleTableColumn<Usuario>[] => [
    ...UsuarioStaticColumns,
    {
        key: 'actions',
        label: '',
        className : 'w-1/6',
        render: (row: Usuario) => {
           return row.role !== 'admin' && (
                <EditAndDeleteActions
                    editHref={UsuarioRoutes.edit(row.id)}
                    deleteOnClick={() => onSelect(row)}
                />
            )
        }
    }
]
