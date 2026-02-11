import SuccessOrFailText from "@/app/shared/components/common/SuccessOrFailText"
import MoneyFlow from "@/app/shared/components/common/MoneyFlow"
import { router } from "@inertiajs/react"
import { moneyFormat } from "@/app/shared/helpers"
import { dateFormat } from "@/app/shared/helpers"
import { type ColumnDef } from "@tanstack/react-table"
import { type MovimientoTableData, type MovimientoShowData, MovimientoRoutes } from "../../types/movimiento.types"
export const MovimientoColumns = ({onSelect}:{onSelect: (item:MovimientoShowData)=> void}) : ColumnDef<MovimientoTableData>[]=>[
    {
        id: 'id',
        header: 'ID',
        accessorKey: 'id'
    },
    {
        id: 'nombre',
        header: 'Nombre',
        accessorKey: 'nombre',
        cell: ({row})=>(
            <button onClick={
                ()=>{
                onSelect(row.original)
                 router.get(MovimientoRoutes.show(row.original.id),{},{
                          preserveState: true,
                          preserveScroll: true
                        })

            }} className="cursor-pointer hover:underline hover:text-blue-500 transition-all">
                <p>{row.original.nombre}</p>
            </button>
        )
    },
    {
        id: 'cuenta',
        header: 'Cuenta',
        accessorKey: 'cuenta'
    },
    {
        id:'categoria',
        header: 'Categoria',
        accessorKey: 'categoria'
    },
    {
        id: 'tipo_movimiento',
        header: 'Tipo',
        accessorKey: 'tipo_movimiento',
        cell : ({row}) => <SuccessOrFailText attribute={row.original.tipo_movimiento} value={'Ingreso'}  />
    },
    {
        id: 'monto',
        header: 'Monto',
        accessorKey: 'monto',
        cell: ({row}) => {
            return (
                <MoneyFlow monto={row.original.monto} tipo_movimiento={row.original.tipo_movimiento} />
            )
        }
    },
    {
        id: 'fecha',
        header: 'Fecha',
        accessorKey: 'fecha',
        cell: ({row}) => dateFormat(row.original.fecha)
    },
    {
        id: 'descripcion',
        header: 'Descripcion',
        accessorKey: 'descripcion',
    },
]