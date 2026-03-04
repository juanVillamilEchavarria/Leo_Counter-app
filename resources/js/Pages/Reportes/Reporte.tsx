import SectionTransition from "@/app/shared/components/common/SectionTransition"
import Title from "@/app/shared/components/common/Title"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import { useOpen } from "@/app/shared/hooks"
import { CardReview, ReporteSheet, IngresoAndGastoChart, CategoriaPieChart, BalanceNetoCardReview , BalanceLineChart, PresupuestoPercentageChart, useReporteApi} from "@/app/domains/reportes"
import IngresoCardReview from "@/app/domains/reportes/components/IngresoCardReview"
import GastoCardReview from "@/app/domains/reportes/components/GastoCardReview"
export default function Reporte() {

  const {isOpen, setIsOpen}= useOpen(false)
  const {isOpen : isOpenCuentas, setIsOpen : setIsOpenCuentas}= useOpen(false)
  console.log(useReporteApi().data)

  return (
    <SectionTransition >
        <div className="flex w-full justify-between mb-5">
          <div className="flex flex-col gap-2">
            <Title title="Reportes" size="3xl" />
            <p>Genera y analiza tus reportes financieros</p>
          </div>
                      <ReporteSheet />
        </div>
        <ul className="my-5">
          <p>Filtros activos:</p>
          <li><i className="fa-solid fa-calendar text-blue-400"></i> Enero 2023 - Diciembre 2023</li>
          <li>
            <button type="button" className="cursor-pointer hover:underline hover:text-blue-500 transition-all" onClick={()=> setIsOpen(prev => !prev)}>
              <i className="fa-solid fa-tag text-orange-400"></i>3 Categorias seleccionadas
            </button>
            <TransitionMotion active={isOpen} initial={{x: 0, y: -20, opacity:0}} exit={{x:0, y:-20, opacity:0}}>
              <ul className="ml-15 mt-1 list-disc text-gray-500">
                <li>Ingresos laborales</li>
                <li>Compras</li>
                <li>Alquileres</li>
              </ul>
            </TransitionMotion>
            
          </li>
          <li>
            <button type="button" className="cursor-pointer hover:underline hover:text-blue-500 transition-all" onClick={()=> setIsOpenCuentas(prev => !prev)}>
              <i className="fa-solid fa-tag text-orange-400"></i>3 Cuentas seleccionadas
            </button>
            <TransitionMotion active={isOpenCuentas} initial={{x: 0, y: -20, opacity:0}} exit={{x:0, y:-20, opacity:0}}>
              <ul className="ml-15 mt-1 list-disc text-gray-500">
                <li>Cuenta Mamá </li>
                <li>Cuenta Juanes</li>
                <li>Cuenta Maria</li>
              </ul>
            </TransitionMotion>
            
          </li>
        </ul>
        <div className="flex w-full gap-10 mx-auto h-full">
         <IngresoCardReview />
         <GastoCardReview />
          <CardReview label="Total de Movimientos" percentage={10.4} tipo_total="numero"  total={400000}>
             <div className="flex flex-col mt-5 gap-2 w-full">
                <div className="flex items-center gap-1">
                    <p className=" text-center font-bold">Volumen de movimientos <span className="text-green-600">4.4%</span> superior en este mes </p>
                <i className="fa-solid fa-arrow-trend-up text-green-500"></i>
                </div>
                <small className="text-gray-400 text-center">Actividad financiera consistente</small>
             </div>
            </CardReview>
            <BalanceNetoCardReview />
        </div>
        <div className="mt-5 w-full flex flex-col">
          <div className="w-full flex gap-3">
            <IngresoAndGastoChart />
            <CategoriaPieChart />

          </div>
          <div className="w-full flex gap-3">
            <BalanceLineChart />
            <PresupuestoPercentageChart />
             
          </div>
          
        </div>
    </SectionTransition>
  )
}
