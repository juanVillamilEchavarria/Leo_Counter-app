import { Bar, BarChart, CartesianGrid, XAxis, YAxis } from "recharts"
import Card from "@/app/shared/components/common/Card"
import FilterOptions from "../Filters/FilterOptions"
import StatisticalSummaryText from "../Summarys/StatisticalSummaryText"
import EmptyDataMessage from "../common/EmptyDataMessage"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/app/shared/components/ui/chart"
import useIngresoAndGastoChart from "../../hooks/Charts/useIngresoAndGastoChart"
import type { IngresoVsGastosChart } from "../../types/reporte.types"
import { ChartModesEnum } from "../../hooks/Charts/Filters/useChartMode"

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
  const {
      mode,
      filteredOptions, 
      displayedPromedios,
      title, 
      filteredData
    } = useIngresoAndGastoChart({
        data: chartData.data,
        promedios: chartData.promedios
      })
  const hasData = chartData.data.length > 0
console.log(filteredData)
  return (
    <Card>
      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h3 className="font-semibold text-lg">{title}</h3>
          </div>
          <FilterOptions options={filteredOptions} />
        </div>
        {hasData ? (
          <>
            <div className="flex flex-wrap gap-4 text-sm">
              {(mode === ChartModesEnum.AMBOS || mode === ChartModesEnum.INGRESO) && (
                <>
                <StatisticalSummaryText color="bg-green-500" valueColor="text-green-700" value={displayedPromedios.ingresos_por_periodo} text="Ingresos promedio por periodo:" type="money" />
                <StatisticalSummaryText color="bg-green-500" valueColor="text-green-700" value={displayedPromedios.ingresos_por_movimiento} text="Ingresos promedio por movimientos:" type="money" />
                </>
                
              )}
              {(mode === ChartModesEnum.AMBOS || mode === ChartModesEnum.GASTO) && (
                <>
                <StatisticalSummaryText color="bg-red-500" valueColor="text-red-700" value={displayedPromedios.gastos_por_periodo} text="Gastos promedio por periodo:" type="money" />
                <StatisticalSummaryText color="bg-red-500" valueColor="text-red-700" value={displayedPromedios.gastos_por_movimiento} text="Gastos promedio por movimientos:" type="money" />
                </> 
              )}
            </div>

            <ChartContainer config={chartConfig} className="h-[300px]">
              <BarChart data={filteredData} barCategoryGap={20}>
                <CartesianGrid vertical={false} strokeDasharray="3 3" stroke="#f0f0f0" />
                <XAxis
                  dataKey="period"
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

                {(mode === ChartModesEnum.AMBOS || mode === ChartModesEnum.INGRESO) && (
                  <Bar dataKey="ingresos" fill="var(--color-ingresos)" radius={[4, 4, 0, 0]} />
                )}
                {(mode === ChartModesEnum.AMBOS || mode === ChartModesEnum.GASTO) && (
                  <Bar dataKey="gastos" fill="var(--color-gastos)" radius={[4, 4, 0, 0]} />
                )}
              </BarChart>
            </ChartContainer>
          </>
        ) : (
          <EmptyDataMessage paragraph="Registra movimientos para ver las tendencias"/>
        )}
      </div>
    </Card>
  )
}