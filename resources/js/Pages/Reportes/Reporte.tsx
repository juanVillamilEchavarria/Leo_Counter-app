import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { CardReview } from "@/app/domains/reportes"
import MoneyFlow from "@/app/shared/components/common/MoneyFlow"
import PercentageFlow from "@/app/shared/components/common/PercentageFlow"
import Card from "@/app/shared/components/common/Card"
import { moneyFormat } from "@/app/shared/helpers"
export default function Reporte() {
  return (
    <SectionTransition>
        <SectionDescription title="Reporte" paragraph="Genera Tus Reportes" />
        <div className="flex w-3/4 gap-2 mx-auto h-full">
         <CardReview label="Total de ingresos" monto={10.4} tipo_movimiento="Ingreso" total={100} tipo_total="dinero" />
         <CardReview label="Total de gastos" monto={10.4} flow="reverse" tipo_movimiento="Gasto" total={100} tipo_total="dinero" />
          <CardReview label="Total de Movimientos" monto={10.4}  tipo_movimiento="Ingreso" total={100}/>
          
        </div>
    </SectionTransition>
  )
}
