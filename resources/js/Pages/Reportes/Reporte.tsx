import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import Title from "@/app/shared/components/common/Title"
import { CardReview, ReporteSheet } from "@/app/domains/reportes"
import IngresoCardReview from "@/app/domains/reportes/components/IngresoCardReview"
import GastoCardReview from "@/app/domains/reportes/components/GastoCardReview"
import MoneyFlow from "@/app/shared/components/common/MoneyFlow"
import PercentageFlow from "@/app/shared/components/common/PercentageFlow"
import Card from "@/app/shared/components/common/Card"
import { moneyFormat } from "@/app/shared/helpers"
export default function Reporte() {
  return (
    <SectionTransition>
        <div className="flex w-full justify-between mb-5">
          <div className="flex flex-col gap-2">
            <Title title="Reportes" size="3xl" />
            <p>Genera y analiza tus reportes financieros</p>
          </div>
                      <ReporteSheet />
        </div>
        <div className="flex w-full gap-10 mx-auto h-full">
         <IngresoCardReview />
         <GastoCardReview />
          <CardReview label="Total de Movimientos" monto={10.4} tipo_total="numero"  total={400000}>
             <div className="flex flex-col mt-5 gap-2 w-full">
                <div className="flex items-center gap-1">
                    <p className=" text-center font-bold">Volumen de movimientos <span className="text-green-600">4.4%</span> superior en este mes </p>
                <i className="fa-solid fa-arrow-trend-up text-green-500"></i>
                </div>
                <small className="text-gray-400 text-center">Actividad financiera consistente</small>
             </div>
            </CardReview>
        </div>
    </SectionTransition>
  )
}
