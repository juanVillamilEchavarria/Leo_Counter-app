/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type ColumnDef } from "@tanstack/react-table"
import { dateFormat } from "@/app/shared/helpers"
import type { AuditoriaTableData } from "../../types/auditoria.types"

/**
 * Columnas para la tabla de auditorías.
 * Sigue el mismo patrón que movimiento.columns.tsx (sin acciones de CRUD).
 */
export const AuditoriaColumns = (): ColumnDef<AuditoriaTableData>[] => [
    {
        id: 'id',
        header: 'ID',
        accessorKey: 'id'
    },
    {
        id: 'user',
        header: 'Usuario',
        accessorKey: 'user',
    },
    {
        id: 'auditable_type',
        header: 'Tipo',
        accessorKey: 'auditable_type'
    },
    {
        id: 'action',
        header: 'Acción',
        accessorKey: 'action'
    },
    {
        id: 'created_at',
        header: 'Fecha',
        accessorKey: 'created_at',
        cell: ({ row }) => dateFormat(row.original.created_at)
    }
]
