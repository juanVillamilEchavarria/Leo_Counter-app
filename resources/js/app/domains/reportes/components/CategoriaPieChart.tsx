import { useMemo } from "react"
import { Pie, PieChart, Cell } from "recharts"
import Card from "@/app/shared/components/common/Card"
import { moneyFormat } from "@/app/shared/helpers"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/app/shared/components/ui/chart"
import type { DistribucionPorCategoria } from "../types/reporte.types"

const pieColors = [
  "var(--chart-1)",
  "var(--chart-2)",
  "var(--chart-3)",
  "var(--chart-4)",
  "var(--chart-5)",
  "var(--chart-6)",
  "var(--chart-7)",
  "var(--chart-8)"
]

const chartConfig = {
  total: { label: "Monto por categoría", color: "#2563eb" },
} satisfies ChartConfig

interface CategoriaPieChartProps {
  distribucion: DistribucionPorCategoria
}

export default function CategoriaPieChart({ distribucion }: CategoriaPieChartProps) {
  // Calculate percentages based on total
  const dataWithPercentages = useMemo(() => {
    const total = distribucion.data.reduce((acc, item) => acc + item.total, 0)
    return distribucion.data.map(item => ({
      ...item,
      percentage: total > 0 ? (item.total / total) * 100 : 0
    }))
  }, [distribucion.data])

  const hasData = distribucion.data.length > 0

  return (
    <Card>
      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h3 className="font-semibold text-lg">Distribución por Categorías</h3>
            <p className="text-sm text-gray-500">
              {hasData ? `${distribucion.total_movimientos} movimientos distribuidos` : 'Análisis de gastos por categoría'}
            </p>
          </div>
        </div>

        {hasData ? (
          <>
            <ChartContainer config={chartConfig} className="h-[280px]">
              <PieChart>
                <ChartTooltip
                  content={<ChartTooltipContent hideLabel />}
                  formatter={(value: number, name: string) => [
                    `${value.toFixed(1)}% • ${moneyFormat(dataWithPercentages.find(d => d.categoria === name)?.total || 0)}`,
                    name
                  ]}
                />
                <Pie
                  data={dataWithPercentages}
                  dataKey="percentage"
                  nameKey="categoria"
                  innerRadius={60}
                  outerRadius={100}
                  paddingAngle={2}
                >
                  {dataWithPercentages.map((entry, index) => (
                    <Cell
                      key={`${entry.categoria}-${index}`}
                      fill={pieColors[index % pieColors.length]}
                    />
                  ))}
                </Pie>
              </PieChart>
            </ChartContainer>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
              {dataWithPercentages
                .sort((a, b) => b.percentage - a.percentage)
                .map((entry, index) => (
                <div key={entry.categoria} className="flex items-center justify-between p-2 rounded-lg bg-gray-50">
                  <div className="flex items-center gap-2">
                    <span
                      className="inline-block h-3 w-3 rounded-full flex-shrink-0"
                      style={{ backgroundColor: pieColors[index % pieColors.length] }}
                    />
                    <span className="text-gray-700 truncate">{entry.categoria}</span>
                  </div>
                  <div className="text-right">
                    <div className="font-semibold text-gray-900">{entry.percentage.toFixed(1)}%</div>
                    <div className="text-xs text-gray-500">{moneyFormat(entry.total)}</div>
                  </div>
                </div>
              ))}
            </div>
          </>
        ) : (
          <div className="flex flex-col items-center justify-center h-[280px] text-center space-y-3">
            <div className="text-gray-400">
              <i className="fa-solid fa-pie-chart text-3xl"></i>
            </div>
            <div>
              <h4 className="font-semibold text-gray-900">No hay datos disponibles</h4>
              <p className="text-sm text-gray-500">Registra movimientos para ver la distribución por categorías</p>
            </div>
          </div>
        )}
      </div>
    </Card>
  )
}

