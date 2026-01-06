import SectionDescription from "@/app/shared/components/common/SectionDescription"
import { type MovimientosMesActualProps } from "@/app/domains/movimiento"
import { dateFormat } from "@/app/shared/helpers"
export default function Index({
  inicio,
  fin
}:MovimientosMesActualProps
) {
  return (
    <div className="section">
      
        <SectionDescription title={`Movimientos Del Mes Actual `} paragraph={` ${dateFormat(inicio)} - ${dateFormat(fin)}`} />
    </div>
  )
}
