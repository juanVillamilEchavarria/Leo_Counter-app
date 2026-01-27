import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import ModelToggle from "@/app/shared/components/table/actions/ModelToggle"
import { Link } from "@inertiajs/react"
import {type MovimientoPendienteTableData, MovimientoPendienteActions, MovimientoPendienteRoutes } from "../../types/movimientoPendiente.types"
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo"

export const MovimientoPendienteColumns=(({
    onDelete
}:{
    onDelete: (movimientoPendiente: MovimientoPendienteTableData)=>void
})=> {return [
    { key : 'id', label : 'ID' },
    { key : 'nombre', label : 'Nombre' },
    { key : 'cuenta', label : 'Cuenta' },
    { key : 'tipo_movimiento', label : 'Tipo' },
    { key : 'categoria', label : 'Categoria' },
    { key : 'movimiento_fijo',
      label : 'Movimiento Fijo',
      render : (row: MovimientoPendienteTableData) => {
        return row.movimiento_fijo ? <Link href={MovimientoFijoRoutes.index()}>{row.movimiento_fijo}</Link> : <span className="text-gray-400 uppercase">No Aplica</span>
      }
         },
    { key : 'monto', label : 'Monto' },
    { key : 'fecha_vencimiento', label : 'Fecha Vencimiento' },
    {
        key: 'estado',
        label: 'Estado',
        render: (row: MovimientoPendienteTableData) => (
          <span className={` font-bold ${row.estado === 'pendiente' ? 'text-yellow-600' : row.estado === 'pagado' ? 'text-green-600' : 'text-red-600'}`}>{row.estado}</span>
        ),

    },
    {
      key: 'actions',
      label: '',
      className: 'w-20',
      render: (row: MovimientoPendienteTableData) => (
        <EditAndDeleteActions
          editHref={MovimientoPendienteRoutes.edit(row.id)}
          deleteOnClick={() => onDelete(row)}
        />
      ),
    },

]})