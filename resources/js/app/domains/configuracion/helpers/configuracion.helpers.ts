import { type SimpleTableColumn } from "@/app/shared/types/components"
/**
 * Remueve las columnas de la configuracion de columnas de algun dominio
 * @param {SimpleTableColumn[]}columns 
 * @param {string[]} columnsToRemove 
 * @returns {SimpleTableColumn[]}
 */
export const removeColumns = <TData extends Record<string, any>>
    (columns : SimpleTableColumn<TData>[], columnsToRemove : string[]) => {
        return columns.filter(column => !columnsToRemove.includes(column.key))
}