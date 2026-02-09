
import { CuentaActions, type Cuenta, CuentaRoutes } from "../../types/cuenta.types"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle"
import { moneyFormat } from "@/app/shared/helpers"


export const CuentaColumns=({ // la hacemos de esta manera para poder pasarle la funcion onSelect que se encargara de abrir el modal
  onSelect,
}:{
  onSelect: (cuenta : Cuenta) => void
})=>[
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
    { key: "saldo_inicial", label: "Saldo Inicial", render: (row: Cuenta) => moneyFormat(Number(row.saldo_inicial)) },
    { key: "saldo_actual", label: "Saldo Actual", render: (row: Cuenta) => moneyFormat(Number(row.saldo_actual)) },
    {key: "propietario", label: "Propietario"},
    { key: "tipo_cuenta", label: "Tipo de cuenta" },
    { key: "notas", label: "Notas" },
    {
      key: 'active',
      label: 'Active',
      className: 'w-40',
      render: (row : Cuenta)=>(
        <ModelToggle
          active={row.active}
          route={CuentaActions.patch(row.id)}
        />
      )
    },
    {
      key: 'actions',
      label: '',
      render: (row: Cuenta)=>(
        <EditAndDeleteActions
         editHref={CuentaRoutes.edit(row.id)} 
        deleteOnClick={()=> onSelect(row)}
        /> //se devuelven los botones de editar y eliminar con su respectivo enlace
      )
    }
  ]