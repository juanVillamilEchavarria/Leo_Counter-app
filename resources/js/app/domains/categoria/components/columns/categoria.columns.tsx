/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import {type Categoria,type CategoriaTableData ,CategoriaActions, CategoriaRoutes, CategoriaToggleTypes } from "../../types/categoria.types";
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle";
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions";
import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText";
import type { SimpleTableColumn } from "@/app/shared/types/components"

export const CategoriaStaticColumns: SimpleTableColumn<CategoriaTableData>[] = [
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre de la categoria", className: 'w-60' },
    { 
      key: "tipo",
       label: "Tipo",
       render: (row : CategoriaTableData)=>(
        <SuccessOrFailText attribute={row.tipo} value={'Ingreso'}  />
       )},
    { key: "descripcion", label: "Descripcion"},
]

export const CategoriaColumns=(({
    onSelect
}:{
    onSelect: (categoria: CategoriaTableData)=>void
}
    
)=>{
    return [
        ...CategoriaStaticColumns,
        {
          key: 'es_fijo',
          label: 'Su frecuencia es fija',
          className: 'w-40',
          render: (row : CategoriaTableData)=>(
            <ModelToggle 
            active={row.es_fijo}
            route={CategoriaActions.toggle(row.id, CategoriaToggleTypes.es_fijo)}
            labels={{
             active: 'Fijo',
             inactive: 'No Fijo'
            }}
            />
          )
        },
        {
          key: 'actions',
          label: '',
          className: 'w-20',
          render: (row : CategoriaTableData)=>{
            
            return row.is_system ? '' :(
            <EditAndDeleteActions 
              editHref={CategoriaRoutes.edit(row.id)}
              deleteOnClick={()=> onSelect(row)}
            />
          )}
        }
      ]
})