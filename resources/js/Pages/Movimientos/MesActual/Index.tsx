import SectionDescription from "@/app/shared/components/SectionDescription"
import { type MovimientosMesActualProps } from "@/app/domains/movimientos"
import { dateFormat } from "@/app/shared/helpers"
export default function Index({
  inicio,
  fin
}:MovimientosMesActualProps
) {
  return (
    <div className="mt-10">
      
        <SectionDescription tittle={`Movimientos Del Mes Actual `} paragraph={` ${dateFormat(inicio)} - ${dateFormat(fin)}`} />
    </div>
  )
}
