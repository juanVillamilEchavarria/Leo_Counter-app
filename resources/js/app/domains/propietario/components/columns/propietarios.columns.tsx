/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"; 
import {Link} from "@inertiajs/react";
import CrudButton from "@/app/shared/components/common/CrudButton";
import ActionSection from "@/app/shared/components/table/actions/ActionSection";
import { router } from "@inertiajs/react";
import {PropietarioRoutes ,type  PropietarioTableData,type PropietarioShowData} from "../../types/propietario.types";

const buildMovimientoPendienteActions = (
  row: PropietarioShowData,
  onSelect: (row: PropietarioShowData, modal: string) => void
) => [
  {
    as: Link,
    href: PropietarioRoutes.edit(row.id),
    Crudvariant: 'Edit',
  },
]
export const PropietarioColumns=({
    onSelect
}:{
    onSelect: (propietario: PropietarioTableData, modal : string)=> void
})=>{

  return [
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre", 
      render : (row: PropietarioTableData) => (
      <button 
          onClick={()=>{
            onSelect(row, 'show')
            router.get(PropietarioRoutes.show(row.id),{},{
                      preserveState: true,
                      preserveScroll: true
                    })}
  
          }
            className="cursor-pointer hover:underline hover:text-blue-500 transition-all">
                  <p>{row.nombre}</p>
          </button>
          )
      
     },
    { key: "apellido", label: "Apellido" },
    { key: "email", label: "Email" },
    { key: "telefono", label: "Telefono" },
    {key : 'no_cuentas', label : '# Cuentas Asociadas', className: 'text-center'},
    {
      key: 'actions',
      label: '',
      className: 'w-20',
      render: (row: PropietarioTableData)=>{
        return row.no_cuentas === 0 ?(
        <EditAndDeleteActions
         editHref={PropietarioRoutes.edit(row.id)} 
        deleteOnClick={()=> onSelect(row, 'delete')} // onSelect recibe el registro de la fila
        />
      ):(
        <div className="w-1/2 mx-auto">
        <ActionSection actions={buildMovimientoPendienteActions(row, onSelect)} as={CrudButton} />
        </div>
      )}
    },
  ]
}