/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { newColumns, type DeletedDomainColumnsProps } from "../utils/configuracion.deleted.columns.utils"
import { CategoriaStaticColumns, type CategoriaTableData } from "@/app/domains/categoria"

export const deletedCategoriaColumns =({
    onSelect
}:DeletedDomainColumnsProps<CategoriaTableData>) =>{
    return newColumns<CategoriaTableData>({
        onSelect:onSelect,
        columns: CategoriaStaticColumns,
        columnsToRemove: ['actions','es_fijo']
    })
    
}