import { newColumns, type DeletedDomainColumnsProps, onSelectDefault } from "../utils/configuracion.deleted.columns.utils"
import { CategoriaColumns } from "@/app/domains/categoria/components/columns/categoria.columns"
import { type CategoriaTableData } from "@/app/domains/categoria"

export const deletedCategoriaColumns =({
    onSelect
}:DeletedDomainColumnsProps<CategoriaTableData>) =>{
    return newColumns<CategoriaTableData>({
        onSelect:onSelect,
        columns: CategoriaColumns({
            onSelect: onSelectDefault<CategoriaTableData>
        }),
        columnsToRemove: ['actions','es_fijo']
    })
    
}