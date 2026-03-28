import { Line, YAxis, XAxis, CartesianGrid, Legend , Area, ComposedChart} from "recharts"
import Card from "@/app/shared/components/common/Card"
import Title from "@/app/shared/components/common/Title"
import EmptyDataMessage from "../common/EmptyDataMessage"
import { ChartContainer, ChartTooltip, ChartTooltipContent } from "@/app/shared/components/ui/chart"
import type { BalanceNetoData } from "../../types/reporte.types"

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
  /** 
   *transforma los datos para que se puedan mostrar en el grafico de manera correcta
  */ 
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
            <Title className="font-bold text-lg " title= "Evolución del Balance Neto" as={'h3'} />
          </div>
        </div>
      </div>

      {hasData ? (
        <ChartContainer config={chartConfig} className="h-75 w-full">
          <ComposedChart
            data={chartData}
            margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
          >
            <CartesianGrid vertical={false} strokeDasharray="3 3" stroke="var(--border)" />
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
       <EmptyDataMessage paragraph="Registra movimientos para ver la evolución del balance neto" />
      )}
    </Card>
  )
}
