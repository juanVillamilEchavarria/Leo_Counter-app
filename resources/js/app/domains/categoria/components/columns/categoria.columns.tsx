import {type Categoria, CategoriaActions, CategoriaRoutes } from "../../types/categoria.types";
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle";
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions";

export const CategoriaColumns=(({
    onSelect
}:{
    onSelect: (categoria: Categoria)=>void
}
    
)=>{
    return [
        { key: "id", label: "ID" },
        { key: "nombre", label: "Nombre de la categoria", className: 'w-60' },
        { key: "tipo", label: "Tipo" },
        { key: "descripcion", label: "Descripcion"},
        {
          key: 'es_fijo',
          label: 'Su frecuencia es fija',
          className: 'w-40',
          render: (row : Categoria)=>(
            <ModelToggle 
            active={row.es_fijo}
            route={CategoriaActions.patch(row.id)}
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
          render: (row : Categoria)=>{
            
            return row.is_system ? '' :(
            <EditAndDeleteActions 
              editHref={CategoriaRoutes.edit(row.id)}
              deleteOnClick={()=> onSelect(row)}
            />
          )}
        }
      ]
})