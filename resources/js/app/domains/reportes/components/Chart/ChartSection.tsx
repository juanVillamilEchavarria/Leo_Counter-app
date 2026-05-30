/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import IngresoAndGastoChart from "./IngresoAndGastoChart"
import CategoriaPieChart from "./CategoriaPieChart"
import Title from "@/app/shared/components/common/Title"
import BalanceLineChart from "./BalanceLineChart"
import PresupuestoPercentageChart from "./PresupuestoPercentageChart"
import type { Tendencia, Distribuciones } from "../../types/reporte.types"

interface ChartSectionProps {
  tendencia: Tendencia
  distribuciones: Distribuciones
}

export default function ChartSection({ tendencia, distribuciones }: ChartSectionProps) {
  return (
    <div className="space-y-8">
      {/* Tendencias Section */}
      <div>
        <div className="flex items-center gap-2 mb-6">
          <i className="fa-solid fa-chart-line text-green-600"></i>
           <Title className="font-bold text-lg " title= "Tendencias y Evolución" as={'h2'} />
        </div>
        <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">
          <IngresoAndGastoChart data={tendencia.ingresos_vs_gastos} />
          <BalanceLineChart data={tendencia.balance_neto_por_fecha} />
        </div>
      </div>

      {/* Distribución y Presupuesto Section */}
      <div>
        <div className="flex items-center gap-2 mb-6">
          <i className="fa-solid fa-pie-chart text-purple-600"></i>
          <Title className="font-bold text-lg " title= "Distribución y Control Presupuestario" as={'h2'} />
        </div>
        <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">
          <CategoriaPieChart distribucion={distribuciones.por_categoria} />
          <PresupuestoPercentageChart data={tendencia.presupuesto} />
        </div>
      </div>
    </div>
  )
}
