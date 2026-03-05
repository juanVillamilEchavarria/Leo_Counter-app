import { LineChart, Line, YAxis, XAxis, CartesianGrid, Legend , Area, ComposedChart} from "recharts"
import Card from "@/app/shared/components/common/Card"
import { moneyFormat } from "@/app/shared/helpers"
import { ChartContainer, ChartTooltip, ChartTooltipContent } from "@/app/shared/components/ui/chart"
import type { BalanceNetoData } from "../types/reporte.types"

const chartConfig = {
    balance:{
        label: "Balance Neto",
        color: "var(--color-azul-claro)",
    }

}

interface BalanceLineChartProps {
  data: BalanceNetoData[]
}

export default function BalanceLineChart({ data }: BalanceLineChartProps) {
  // Transform data to number format for chart
  const chartData = data.map(item => ({
    fecha: item.fecha,
    balance: parseFloat(item.balance)
  }))

  const hasData = data.length > 0

  return (
    <Card>
      <div className="flex w-full flex-col gap-2 my-3">
        <div className="flex w-full justify-between">
          <div className="flex flex-col gap-2">
            <h3 className="font-bold text-lg">Evolución del Balance Neto</h3>
            <p className="text-gray-500 text-sm">Tendencia mensual de los últimos 6 meses</p>
          </div>
        </div>
      </div>

      {hasData ? (
        <ChartContainer config={chartConfig} className="h-[300px] w-full">
          <ComposedChart
            data={chartData}
            margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
          >
            <CartesianGrid vertical={false} strokeDasharray="3 3" stroke="#f0f0f0" />
            <XAxis
              tickLine={false}
              axisLine={false}
              tick={{ fontSize: 12, fill: '#6b7280' }}
              dataKey="fecha"
            />
            <YAxis
              tickLine={false}
              axisLine={false}
              tick={{ fontSize: 12, fill: '#6b7280' }}
              tickFormatter={(value) => `$${value.toLocaleString()}`}
            />
            <ChartTooltip
              content={<ChartTooltipContent />}
              labelFormatter={(label) => `Fecha: ${label}`}
            />
            <Legend />
            <Line
              type="monotone"
              dataKey="balance"
              stroke="var(--color-azul-claro)"
              strokeWidth={3}
              activeDot={{ r: 6, strokeWidth: 0, fill: 'var(--color-azul-claro)' }}
              dot={{ r: 4, strokeWidth: 2, fill: 'white', stroke: 'var(--color-azul-claro)' }}
            />
            <Area
              type="monotone"
              dataKey="balance"
              stroke="var(--color-azul-claro)"
              fill="var(--color-azul-claro)"
              fillOpacity={0.1}
              strokeWidth={2}
            />
          </ComposedChart>
        </ChartContainer>
      ) : (
        <div className="flex flex-col items-center justify-center h-[300px] text-center space-y-3">
          <div className="text-gray-400">
            <i className="fa-solid fa-chart-line text-3xl"></i>
          </div>
          <div>
            <h4 className="font-semibold text-gray-900">No hay datos disponibles</h4>
            <p className="text-sm text-gray-500">Registra movimientos para ver la evolución del balance</p>
          </div>
        </div>
      )}
    </Card>
  )
}
