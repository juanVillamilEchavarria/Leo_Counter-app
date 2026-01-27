import TanStackTable from "@/app/shared/components/table/advanced/TanStackTable"
import { ColumnsTablePresupuestoHistorico, type PresupuestoHistoricoTableData } from "../types/presupuesto.types"

interface PresupuestoHistoricoTableProps {
  data: PresupuestoHistoricoTableData[]
}

export default function PresupuestoHistoricoTable({ data }: PresupuestoHistoricoTableProps) {        
  return (
    <TanStackTable<PresupuestoHistoricoTableData>
      columns={ColumnsTablePresupuestoHistorico}
      data={data}
    />
  )
}
