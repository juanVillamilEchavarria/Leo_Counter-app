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