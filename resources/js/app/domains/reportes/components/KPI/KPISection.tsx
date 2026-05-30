/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import IngresoCardReview from "./IngresoCardReview"
import GastoCardReview from "./GastoCardReview"
import MovimientosCardReview from "./MovimientosCardReview"
import BalanceNetoCardReview from "./BalanceNetoCardReview"
import type { KPIs } from "../../types/reporte.types"

interface KPISectionProps {
  kpis: KPIs
}

export default function KPISection({ kpis }: KPISectionProps) {
  return (
    <div className="mb-8">
      <div className="flex items-center gap-2 mb-6">
        <i className="fa-solid fa-chart-bar text-blue-600"></i>
        <h2 className="text-xl font-bold text-foreground">Indicadores Clave de Rendimiento</h2>
      </div>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <IngresoCardReview
          total={kpis.totales.ingresos}
          variacion={kpis.variaciones.ingresos}
        />
        <GastoCardReview
          total={kpis.totales.gastos}
          variacion={kpis.variaciones.gastos}
        />
        <MovimientosCardReview
          total={kpis.totales.movimientos}
          variacion={kpis.variaciones.movimientos}
        />
        <BalanceNetoCardReview
          total={kpis.totales.balance_neto}
          variacion={kpis.variaciones.balance_neto}
        />
      </div>
    </div>
  )
}
