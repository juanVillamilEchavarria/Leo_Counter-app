import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"; 
import { type Propietario, PropietarioActions, PropietarioRoutes } from "../../types/propietario.types";

export const PropietarioColumns=({
    onSelect
}:{
    onSelect: (propietario: Propietario)=> void // cuando se le de click al boton de eliminar hace esta funcion, en este caso, recibe un propietario
})=>{

  return [
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
    { key: "apellido", label: "Apellido" },
    { key: "email", label: "Email" },
    { key: "telefono", label: "Telefono" },
    {
      key: 'actions',
      label: '',
      className: 'w-20',
      render: (row: Propietario)=>(
        <EditAndDeleteActions
         editHref={PropietarioRoutes.edit(row.id)} 
        deleteOnClick={()=> onSelect(row)} // onSelect recibe el registro de la fila
        />
      )
    },
  ]
}