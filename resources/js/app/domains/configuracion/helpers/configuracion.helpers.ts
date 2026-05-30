/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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