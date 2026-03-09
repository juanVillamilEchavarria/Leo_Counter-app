import { useMemo, useState } from "react"
import { Bar, BarChart, CartesianGrid, XAxis, YAxis } from "recharts"
import Card from "@/app/shared/components/common/Card"
import { moneyFormat } from "@/app/shared/helpers"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/app/shared/components/ui/chart"
import type { IngresoVsGastosChart } from "../../types/reporte.types"

type ChartMode = "ambos" | "ingresos" | "gastos"

const chartConfig = {
  ingresos: {
    label: "Ingresos",
    color: "var(--chart-income)",
  },
  gastos: {
    label: "Gastos",
    color: "var(--chart-expense)",
  },
} satisfies ChartConfig

interface IngresoAndGastoChartProps {
  data: IngresoVsGastosChart
}

export default function IngresoAndGastoChart({ data: chartData }: IngresoAndGastoChartProps) {
  const [mode, setMode] = useState<ChartMode>("ambos")

  const title = useMemo(() => {
    if (mode === "ingresos") return "Ingresos mensuales"
    if (mode === "gastos") return "Gastos mensuales"
    return "Ingresos vs Gastos"
  }, [mode])

  // Filter data based on selected mode
  const filteredData = useMemo(() => {
    return chartData.data.map(item => ({
      mes: item.mes,
      ingresos: mode === "gastos" ? 0 : item.ingresos,
      gastos: mode === "ingresos" ? 0 : item.gastos,
    }))
  }, [mode, chartData.data])

  const displayedPromedios = useMemo(() => {
    return {
      ingresos: mode === "gastos" ? 0 : chartData.promedios.ingresos,
      gastos: mode === "ingresos" ? 0 : chartData.promedios.gastos,
    }
  }, [mode, chartData.promedios])

  const hasData = chartData.data.length > 0

  return (
    <Card>
      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h3 className="font-semibold text-lg">{title}</h3>
            <p className="text-sm text-gray-500">Comparativa mensual de los últimos 6 meses</p>
          </div>

          <div className="inline-flex rounded-lg border border-gray-200 p-1 bg-gray-50">
            <button
              type="button"
              onClick={() => setMode("ambos")}
              className={`px-3 py-1.5 text-sm rounded-md transition-all ${
                mode === "ambos" ? "bg-white text-gray-900 shadow-sm" : "text-gray-600 hover:bg-white/50"
              }`}
            >
              Ambos
            </button>
            <button
              type="button"
              onClick={() => setMode("ingresos")}
              className={`px-3 py-1.5 text-sm rounded-md transition-all ${
                mode === "ingresos" ? "bg-white text-gray-900 shadow-sm" : "text-gray-600 hover:bg-white/50"
              }`}
            >
              Ingresos
            </button>
            <button
              type="button"
              onClick={() => setMode("gastos")}
              className={`px-3 py-1.5 text-sm rounded-md transition-all ${
                mode === "gastos" ? "bg-white text-gray-900 shadow-sm" : "text-gray-600 hover:bg-white/50"
              }`}
            >
              Gastos
            </button>
          </div>
        </div>

        {hasData ? (
          <>
            <div className="flex flex-wrap gap-4 text-sm">
              {(mode === "ambos" || mode === "ingresos") && (
                <div className="flex items-center gap-2">
                  <div className="w-3 h-3 rounded-full bg-green-500"></div>
                  <span className="text-gray-600">Ingresos promedio:</span>
                  <span className="font-semibold text-green-700">{moneyFormat(displayedPromedios.ingresos)}</span>
                </div>
              )}
              {(mode === "ambos" || mode === "gastos") && (
                <div className="flex items-center gap-2">
                  <div className="w-3 h-3 rounded-full bg-red-500"></div>
                  <span className="text-gray-600">Gastos promedio:</span>
                  <span className="font-semibold text-red-700">{moneyFormat(displayedPromedios.gastos)}</span>
                </div>
              )}
            </div>

            <ChartContainer config={chartConfig} className="h-[300px]">
              <BarChart data={filteredData} barCategoryGap={20}>
                <CartesianGrid vertical={false} strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis
                  dataKey="mes"
                  tickLine={false}
                  axisLine={false}
                  tick={{ fontSize: 12, fill: '#6b7280' }}
                />
                <YAxis
                  tickLine={false}
                  axisLine={false}
                  width={60}
                  tick={{ fontSize: 12, fill: '#6b7280' }}
                  tickFormatter={(value) => `$${value.toLocaleString()}`}
                />
                <ChartTooltip
                  cursor={{ fill: 'rgba(0, 0, 0, 0.1)' }}
                  content={<ChartTooltipContent />}
                />

                {(mode === "ambos" || mode === "ingresos") && (
                  <Bar dataKey="ingresos" fill="var(--color-ingresos)" radius={[4, 4, 0, 0]} />
                )}
                {(mode === "ambos" || mode === "gastos") && (
                  <Bar dataKey="gastos" fill="var(--color-gastos)" radius={[4, 4, 0, 0]} />
                )}
              </BarChart>
            </ChartContainer>
          </>
        ) : (
          <div className="flex flex-col items-center justify-center h-[300px] text-center space-y-3">
            <div className="text-gray-400">
              <i className="fa-solid fa-chart-bar text-3xl"></i>
            </div>
            <div>
              <h4 className="font-semibold text-gray-900">No hay datos disponibles</h4>
              <p className="text-sm text-gray-500">Registra movimientos para ver las tendencias</p>
            </div>
          </div>
        )}
      </div>
    </Card>
  )
}