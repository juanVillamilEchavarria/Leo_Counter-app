import { Line, YAxis, XAxis, CartesianGrid, Legend , Area, ComposedChart} from "recharts"
import Card from "@/app/shared/components/common/Card"
import EmptyDataMessage from "@/app/domains/reportes/components/common/EmptyDataMessage"
import { ChartContainer, ChartTooltip, ChartTooltipContent } from "@/app/shared/components/ui/chart"
import { type IngresoVsGastoData } from "@/app/domains/reportes/types/reporte.types"

const chartConfig = {
  ingresos: {
    label: "Ingresos",
    color: "var(--chart-income)",
  },
  gastos: {
    label: "Gastos",
    color: "var(--chart-expense)",
  },
}
interface IngresoAndGastoLineChartProps {
  data : IngresoVsGastoData[]
}

export default function IngresoAndGastoLineChart({ data }: IngresoAndGastoLineChartProps) {
   /** 
     *transforma los datos para que se puedan mostrar en el grafico de manera correcta
    */ 
   const chartData = data.map(item => ({
     fecha: item.period,
     ingresos: item.ingresos,
     gastos: item.gastos
   }))
   console.log(data);
   console.log(chartData);
  
    const hasData = data.length > 0
  
    return (
      <Card>
        <div className="flex w-full flex-col gap-2 my-3">
          <div className="flex w-full justify-between">
            <div className="flex flex-col gap-2">
              <h3 className="font-bold text-lg">Ingresos y Gastos</h3>
            </div>
          </div>
        </div>
  
        {hasData ? (
          <ChartContainer config={chartConfig} className="h-75 w-full">
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
                labelFormatter={(label) => `fecha: ${label}`}
              />
              <Legend />
              <Line
                type="monotone"
                dataKey="ingresos"
                stroke="var(--color-verde)"
                strokeWidth={3}
                activeDot={{ r: 6, strokeWidth: 0, fill: 'var(--chart-income)' }}
                dot={{ r: 4, strokeWidth: 2, fill: 'white', stroke: 'var(--chart-income)' }}
              />
              <Area
                type="monotone"
                dataKey="ingresos"
                stroke="var(--chart-income)"
                fill="var(--chart-income)"
                fillOpacity={0.1}
                strokeWidth={2}
              />

              <Line
                type="monotone"
                dataKey="gastos"
                stroke="var(--color-rojo)"
                strokeWidth={3}
                activeDot={{ r: 6, strokeWidth: 0, fill: 'var(--chart-expense)' }}
                dot={{ r: 4, strokeWidth: 2, fill: 'white', stroke: 'var(--chart-expense)' }}
              />
              <Area
                type="monotone"
                dataKey="gastos"
                stroke="var(--chart-expense)"
                fill="var(--chart-expense)"
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
