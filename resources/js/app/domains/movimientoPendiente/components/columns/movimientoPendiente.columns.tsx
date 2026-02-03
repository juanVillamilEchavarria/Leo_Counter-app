import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import ActionSection from "@/app/shared/components/table/actions/ActionSection"
import { Link } from "@inertiajs/react"
import Button from "@/app/shared/components/common/Button"
import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"
import {type MovimientoPendienteTableData, MovimientoPendienteActions, MovimientoPendienteRoutes } from "../../types/movimientoPendiente.types"
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo"
import { dateFormat } from "@/app/shared/helpers"
import CrudButton from "@/app/shared/components/common/CrudButton"
const buildMovimientoPendienteActions = (
  row: MovimientoPendienteTableData,
  onDelete: (row: MovimientoPendienteTableData, modal: string) => void
) => [
  {
    as: Link,
    href: MovimientoPendienteRoutes.edit(row.id),
    Crudvariant: 'Edit',
  },
  {
    onClick: () => onDelete(row, 'delete'),
    Crudvariant: 'Delete',
  },
  {
    onClick: () => onDelete(row, 'pagar'),
    Crudvariant: 'Create',
    icon: 'fa-solid fa-cash-register fa-sm',
    className: 'p-2! m-0!',
    withSpan: false
  }
]

export const MovimientoPendienteColumns=(({
    onDelete
}:{
    onDelete: (movimientoPendiente: MovimientoPendienteTableData, modal : string)=>void
})=> {return [
    { key : 'id', label : 'ID' },
    { key : 'nombre', label : 'Nombre' },
    { key : 'cuenta', label : 'Cuenta' },
    { key : 'tipo_movimiento', label : 'Tipo',
      render: (row: MovimientoPendienteTableData) => (
       <SuccessOrFailText
         attribute={row.tipo_movimiento}
         value="Ingreso"
       />
      )
     },
    { key : 'categoria', label : 'Categoria' },
    { key : 'movimiento_fijo',
      label : 'Movimiento Fijo',
      render : (row: MovimientoPendienteTableData) => {
        return row.movimiento_fijo ? <Link href={MovimientoFijoRoutes.index()}>{row.movimiento_fijo}</Link> : <span className="text-gray-400 uppercase">No Aplica</span>
      }
         },
    { key : 'monto', label : 'Monto' },
    { key : 'fecha_programada', label : 'Fecha Programada', render: (row: MovimientoPendienteTableData)=>(dateFormat(row.fecha_programada)) },
    {
        key: 'estado',
        label: 'Estado',
        render: (row: MovimientoPendienteTableData) => (
          <span className={` font-bold ${row.estado === 'pendiente' ? 'text-yellow-600' : row.estado === 'realizado' ? 'text-green-600' : 'text-red-600'}`}>{row.estado}</span>
        ),

    },
    {
      key: 'actions',
      label: '',
      render: (row: MovimientoPendienteTableData) => (
        <ActionSection actions={buildMovimientoPendienteActions(row, onDelete)} as={CrudButton} />
      ),
    },

]})