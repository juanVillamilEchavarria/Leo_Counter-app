
import { CuentaActions, type Cuenta } from "../../types/cuenta.types"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import { CuentaRoutes} from "../../types/cuenta.types"
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle"


export const CuentaColumns=[
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
    { key: "saldo_inicial", label: "Saldo Inicial" },
    { key: "saldo_actual", label: "Saldo Actual" },
    {key: "propietario", label: "Propietario"},
    { key: "tipo_cuenta", label: "Tipo de cuenta" },
    { key: "notas", label: "Notas" },
    {
      key: 'active',
      label: 'Active',
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
        <EditAndDeleteActions editHref={CuentaRoutes.edit(row.id)} deleteIcon='fa-solid fa-box-archive' /> //se devuelven los botones de editar y eliminar con su respectivo enlace
      )
    }
  ]