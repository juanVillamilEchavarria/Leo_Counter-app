import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { MovimientoTable, type Movimiento } from "@/app/domains/movimiento"
import { type MovimientoTableData, type MovimientoShowData } from "@/app/domains/movimiento"
export default function Index({
  movimientos,
  data
}:{
  movimientos : {data: MovimientoTableData[]}
  data?: {data: MovimientoShowData}
}) {
  return (
    <SectionTransition>
        <SectionDescription title="Movimientos" paragraph="Mira el historial de tus ingresos y gastos" />
        <MovimientoTable data={movimientos.data} showData={data?.data} />
    </SectionTransition>
  )
}
