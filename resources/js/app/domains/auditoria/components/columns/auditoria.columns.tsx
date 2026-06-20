/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import ActionOutput from "../ActionOutput"
import { type ColumnDef } from "@tanstack/react-table"
import { dateFormat } from "@/app/shared/helpers"
import type { AuditoriaTableData } from "../../types/auditoria.types"
import ValuesReview from "../ValuesReview"

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
        accessorKey: 'action',
        cell: ({ row})=>(
            <ActionOutput action={row.original.action} />
        )
    },
    {
        id: 'old_values',
        header: 'Valores anteriores',
        accessorKey: 'old_values',
        cell: ({row})=>{
            return row.original.old_values && (
            <ValuesReview iterable={row.original.old_values} />
        )}
    },
    {
        id: 'new_values',
        header: 'Valores nuevos',
        accessorKey: 'new_values',
        cell: ({row})=>{
            return row.original.new_values && (
            <ValuesReview iterable={row.original.new_values} />
        )
        }
    },
    {
        id: 'created_at',
        header: 'Fecha',
        accessorKey: 'created_at',
        cell: ({ row }) => dateFormat(row.original.created_at)
    }
]
