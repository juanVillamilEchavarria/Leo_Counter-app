import { Line, YAxis, XAxis, CartesianGrid, Legend , Area, ComposedChart} from "recharts"
import Card from "@/app/shared/components/common/Card"
import StatisticalSummaryText from "@/app/domains/reportes/components/Summarys/StatisticalSummaryText"
import EmptyDataMessage from "@/app/domains/reportes/components/common/EmptyDataMessage"
import Title from "@/app/shared/components/common/Title"
import { ChartContainer, ChartTooltip, ChartTooltipContent } from "@/app/shared/components/ui/chart"
import { type IngresoVsGastoChart } from "@/app/domains/reportes/types/reporte.types"

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
  data : IngresoVsGastoChart

}

export default function IngresoAndGastoLineChart({ data }: IngresoAndGastoLineChartProps) {
   /** 
     *transforma los datos para que se puedan mostrar en el grafico de manera correcta
    */ 
   const {data : statisticData, promedios} = data
   const chartData = statisticData.map(item => ({
     fecha: item.period,
     ingresos: item.ingresos,
     gastos: item.gastos
   }))

  
    const hasData = statisticData.length > 0
  
    return (
      <Card>
        <div className="flex w-full flex-col gap-2 my-3">
          <div className="flex w-full justify-between">
            <div className="flex flex-col gap-2">
               <Title as={'h3'} className="font-semibold text-lg" title="Ingresos y Gastos"/>
            </div>
          </div>
          <p className="text-foreground">Promedios</p>
          <div className="grid grid-cols-2 gap-2 self-start text-sm">
            
            <StatisticalSummaryText
              text="Ingresos por movimiento"
              color="bg-green-300"
              valueColor="text-green-500"
              value={promedios.ingresos_por_movimiento}
            />
            <StatisticalSummaryText
              text="Ingresos por periodo"
              color="bg-green-300"
              valueColor="text-green-500"
              value={promedios.ingresos_por_periodo}
            />
            <StatisticalSummaryText
              text="Gastos por movimiento"
              color="bg-red-300"
              valueColor="text-red-500"
              value={promedios.gastos_por_movimiento}
            />
            <StatisticalSummaryText
              text="Gastos por periodo"
              color="bg-red-300"
              valueColor="text-red-500"
              value={promedios.gastos_por_periodo}
            />
          </div>
        </div>
  
        {hasData ? (
          <ChartContainer config={chartConfig} className="h-80 w-full">
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
                content={<ChartTooltipContent labelClassName="font-foreground" />}
                labelFormatter={(label) => `fecha: ${label}`}
              />
              <Legend />
              <Line
                type="monotone"
                dataKey="ingresos"
                stroke="var(--color-verde)"
                strokeWidth={3}
                activeDot={{ r: 6, strokeWidth: 0, fill: 'var(--chart-income-area)' }}
                dot={{ r: 4, strokeWidth: 2, fill: 'white', stroke: 'var(--chart-income-area)' }}
              />
              <Area
                type="monotone"
                dataKey="ingresos"
                stroke="var(--chart-income-area)"
                fill="var(--chart-income-area)"
                fillOpacity={0.1}
                strokeWidth={2}
              />

              <Line
                type="monotone"
                dataKey="gastos"
                stroke="var(--color-rojo)"
                strokeWidth={3}
                activeDot={{ r: 6, strokeWidth: 0, fill: 'var(--chart-expense-area)' }}
                dot={{ r: 4, strokeWidth: 2, fill: 'white', stroke: 'var(--chart-expense-area)' }}
              />
              <Area
                type="monotone"
                dataKey="gastos"
                stroke="var(--chart-expense-area)"
                fill="var(--chart-expense-area)"
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
