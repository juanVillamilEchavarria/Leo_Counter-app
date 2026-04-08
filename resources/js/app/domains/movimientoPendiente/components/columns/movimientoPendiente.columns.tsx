import ActionSection from "@/app/shared/components/table/actions/ActionSection"
import { Link } from "@inertiajs/react"
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"
import { router } from "@inertiajs/react"
import {type MovimientoPendienteShowData ,MovimientoPendienteRoutes, type MovimientoPendienteTableData } from "../../types/movimientoPendiente.types"
import { CuentaRoutes } from "@/app/domains/cuenta"
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo"
import { dateFormat } from "@/app/shared/helpers"
import { moneyFormat } from "@/app/shared/helpers"
import CrudButton from "@/app/shared/components/common/CrudButton"
import type { SimpleTableColumn } from "@/app/shared/types/components"

export const MovimientoPendienteStaticColumns: SimpleTableColumn<MovimientoPendienteTableData>[] = [
    { key : 'id', label : 'ID' },
    { key : 'nombre', label : 'Nombre' },
    {
       key : 'cuenta',
        label : 'Cuenta' 
      },
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
         },
    { key : 'monto', label : 'Monto', render: (row: MovimientoPendienteTableData) => moneyFormat(Number(row.monto)) },
    { key : 'fecha_programada', label : 'Fecha Programada', render: (row: MovimientoPendienteTableData)=>(dateFormat(row.fecha_programada)) },
    {
        key: 'estado',
        label: 'Estado',
        render: (row: MovimientoPendienteTableData) => (
          <span className={` font-bold ${row.estado === 'pendiente' ? 'text-yellow-600' : row.estado === 'realizado' ? 'text-green-600' : 'text-red-600'}`}>{row.estado}</span>
        ),

    },
]

const buildMovimientoPendienteActions = (
  row: MovimientoPendienteShowData,
  onSelect: (row: MovimientoPendienteShowData, modal: string) => void
) => [
  {
    as: Link,
    href: MovimientoPendienteRoutes.edit(row.id),
    Crudvariant: 'Edit',
  },
  {
    onClick: () => onSelect(row, 'delete'),
    Crudvariant: 'Delete',
  },
  {
    onClick: () => onSelect(row, 'markAsDone'),
    Crudvariant: 'Create',
    icon: 'fa-solid fa-cash-register fa-sm',
    className: 'p-2! m-0!',
    withSpan: false
  }
]

export const MovimientoPendienteColumns=(({
    onSelect
}:{
    onSelect: (movimientoPendiente: MovimientoPendienteShowData, modal : string)=>void
})=> {return  [
    ...MovimientoPendienteStaticColumns.map(col => {
      if(col.key === 'nombre') {
        return {
          ...col,
          render: (row: MovimientoPendienteShowData) => (
            <button 
            onClick={()=>{
              onSelect(row, 'show')
              router.get(MovimientoPendienteRoutes.show(row.id),{},{
                        preserveState: true,
                        preserveScroll: true
                      })}
            }
             className="cursor-pointer hover:underline hover:text-blue-500 transition-all">
                    <p>{row.nombre}</p>
                </button>
          )
        }
      }
      if(col.key === 'cuenta') {
        return {
          ...col,
          render : (row: MovimientoPendienteShowData) => {
             if(row.tipo_movimiento === 'Ingreso' ){
              return <Link className="cursor-pointer hover:underline transition-all" href={CuentaRoutes.index()}>{row.cuenta}</Link>  
             }
            return row.enough_balance ? (
              <Link className="cursor-pointer hover:underline transition-all" href={CuentaRoutes.index()}>{row.cuenta}</Link>
            ):(
              <div className="flex items-center text-red-400">
               
                <Link className="cursor-pointer hover:underline transition-all" href={CuentaRoutes.index()}>{row.cuenta}</Link>
                 <i className="fa-solid fa-coins"></i>
                 <i className="fa-solid fa-exclamation"></i>
                 
              </div>
            )
          }
        }
      }
      if(col.key === 'movimiento_fijo') {
        return {
          ...col,
          render : (row: MovimientoPendienteShowData) => {
            return row.movimiento_fijo ? <Link href={MovimientoFijoRoutes.index()}>{row.movimiento_fijo}</Link> : <span className="text-muted-foreground uppercase">No Aplica</span>
          }
        }
      }
      return col
    }),
    {
      key: 'actions',
      label: '',
      render: (row: MovimientoPendienteShowData) => {
         if(row.tipo_movimiento === 'Ingreso' ){
            return <ActionSection actions={buildMovimientoPendienteActions(row, onSelect)} as={CrudButton} /> 
           }
        
        return row.enough_balance ?(
        <ActionSection actions={buildMovimientoPendienteActions(row, onSelect)} as={CrudButton} />
      ):(
        <EditAndDeleteActions editHref={MovimientoPendienteRoutes.edit(row.id)} deleteOnClick={()=> onSelect(row,'delete')} />
      )},
    },

]})
