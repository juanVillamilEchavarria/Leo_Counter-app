import IngresoAndGastoChart from "./IngresoAndGastoChart"
import CategoriaPieChart from "./CategoriaPieChart"
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
          <i className="fa-solid fa-trend-up text-green-600"></i>
          <h2 className="text-xl font-bold text-gray-900">Tendencias y Evolución</h2>
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
          <h2 className="text-xl font-bold text-gray-900">Distribución y Control Presupuestario</h2>
        </div>
        <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">
          <CategoriaPieChart distribucion={distribuciones.por_categoria} />
          <PresupuestoPercentageChart data={tendencia.presupuesto} />
        </div>
      </div>
    </div>
  )
}
