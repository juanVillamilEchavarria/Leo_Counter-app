/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { CuentaActions, type Cuenta, CuentaRoutes, CuentaToggleTypes } from "../../types/cuenta.types"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle"
import { moneyFormat } from "@/app/shared/helpers"
import type { SimpleTableColumn } from "@/app/shared/types/components"
export const CuentaStaticColumns =[
 { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
    { key: "saldo_inicial", label: "Saldo Inicial", render: (row: Cuenta) => moneyFormat(Number(row.saldo_inicial)) },
    { key: "saldo_actual", label: "Saldo Actual", render: (row: Cuenta) => moneyFormat(Number(row.saldo_actual)) },
    {key: "propietario", label: "Propietario"},
    { key: "tipo_cuenta", label: "Tipo de cuenta" },
    { key: "notas", label: "Notas" }
]
/**
 * Retorna las columnas de la tabla de cuentas
 * @param {Function} onSelect 
 * @returns {Array}
 */
export const CuentaColumns=({ 
  onSelect,
}:{
  onSelect: (cuenta : Cuenta) => void
}) : SimpleTableColumn<Cuenta>[]=>[
  ...CuentaStaticColumns,
    {
      key: 'active',
      label: 'Active',
      className: 'w-40',
      render: (row : Cuenta)=>(
        <ModelToggle
          active={row.active}
          route={CuentaActions.toggle(row.id, CuentaToggleTypes.active)}
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