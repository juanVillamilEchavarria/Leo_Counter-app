/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Title from "@/app/shared/components/common/Title"
import { Pie, PieChart, Cell } from "recharts"
import Card from "@/app/shared/components/common/Card"
import { moneyFormat } from "@/app/shared/helpers"
import EmptyDataMessage from "../common/EmptyDataMessage"
import FilterOptions from "../Filters/FilterOptions"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/app/shared/components/ui/chart"
import useCategoriaPieChart from "../../hooks/Charts/useCategoriaPieChart"
import type { DistribucionPorCategoria } from "../../types/reporte.types"

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
  const {filteredData, filteredOptions} = useCategoriaPieChart({data: distribucion.data})
  const hasData = filteredData.length > 0

  return (
    <Card>
      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <div>
            <Title className="font-bold text-lg " title= "Distribución por Categorías" as={'h3'} />
            <p className="text-sm text-muted-foreground">
              {hasData ? `${distribucion.total_movimientos} movimientos distribuidos` : 'Análisis de gastos por categoría'}
            </p>
          </div>
          <FilterOptions options={filteredOptions} />
        </div>

        {hasData ? (
          <>
            <ChartContainer config={chartConfig} className="h-70">
              <PieChart>
                <ChartTooltip
                  content={<ChartTooltipContent hideLabel />}
                  formatter={(value: number, name: string) => [
                    `${value.toFixed(1)}% • ${moneyFormat(filteredData.find(d => d.categoria === name)?.total || 0)}`,
                    name
                  ]}
                />
                <Pie
                  data={filteredData}
                  dataKey="percentage"
                  nameKey="categoria"
                  innerRadius={60}
                  outerRadius={100}
                  paddingAngle={2}
                >
                  {filteredData.map((entry, index) => (
                    <Cell
                      key={`${entry.categoria}-${index}`}
                      fill={pieColors[index % pieColors.length]}
                    />
                  ))}
                </Pie>
              </PieChart>
            </ChartContainer>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
              {filteredData
                .sort((a, b) => b.percentage - a.percentage)
                .map((entry, index) => (
                <div key={entry.categoria} className="flex items-center justify-between p-2 rounded-lg bg-muted">
                  <div className="flex items-center gap-2">
                    <span
                      className="inline-block h-3 w-3 rounded-full shrink-0"
                      style={{ backgroundColor: pieColors[index % pieColors.length] }}
                    />
                    <span className="text-muted-foreground truncate">{entry.categoria}</span>
                  </div>
                  <div className="text-right">
                    <div className="font-semibold text-foreground">{entry.percentage.toFixed(1)}%</div>
                    <div className="text-xs text-muted-foreground">{moneyFormat(entry.total)}</div>
                  </div>
                </div>
              ))}
            </div>
          </>
        ) : (
          <EmptyDataMessage
            paragraph="Registra movimientos para ver la distribución por categoría"
          />
        )}
      </div>
    </Card>
  )
}

