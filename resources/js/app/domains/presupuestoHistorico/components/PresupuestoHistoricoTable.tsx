import TanStackTable from "@/app/shared/components/table/advanced/TanStackTable"
import { ColumnsTablePresupuestoHistorico } from "../types/presupuesto.types"
export default function PresupuestoHistoricoTable() {        
  return (
    <TanStackTable
    columns={ColumnsTablePresupuestoHistorico}
       data={[
             {
               id: 1,
               nombre: 'Juan'
             }
           ]}
     />
  )
}
