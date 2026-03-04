import { LineChart, Line, YAxis, XAxis, CartesianGrid, Legend , Area, ComposedChart} from "recharts"
import Card from "@/app/shared/components/common/Card"
import { ChartContainer, ChartTooltip, ChartTooltipContent } from "@/app/shared/components/ui/chart"


const data = [
    {
      name: 'Page A',
      uv: 4000,
      pv: 2400,
      amt: 2400,
    },
    {
      name: 'Page B',
      uv: 3000,
      pv: 1398,
      amt: 2210,
    },
    {
      name: 'Page C',
      uv: 2000,
      pv: 9800,
      amt: 2290,
    },
    {
      name: 'Page D',
      uv: 2780,
      pv: 3908,
      amt: 2000,
    }
]

const chartConfig = {
    pv:{
        label: "Ingresos",
        color: "var(--chart-income)",
    }

}
export default function BalanceLineChart() {
  return (
    <Card className="">
    <div className="flex w-full flex-col gap-2 my-3">
        <div className="flex w-full justify-between">
            <div className="flex flex-col gap-2">
                <h3 className="font-bold">Balance neto</h3>
                <p className="text-gray-500 text-sm">Ultimos 6 meses</p>
            </div>
        </div>
    </div>

        
        <ChartContainer config={chartConfig} className="h-90 w-full">
            <ComposedChart
              data={data}
              margin={{ top: 5, right: 0, left: 0, bottom: 5 }}
            >
              <CartesianGrid vertical={false} stroke="var(--border)" strokeDasharray="4 4" />
              <XAxis tickLine={false} axisLine={false} tick={{fontSize: 12}} dataKey="name" />
              <YAxis tickLine={false} axisLine={false} tick={{fontSize: 12}} />
              <ChartTooltip content={<ChartTooltipContent />} />
              <Legend />
              <Line
                type="monotone"
                dataKey="pv"
                stroke="var(--color-azul-claro)"
                strokeWidth={4}
                activeDot={{ r: 8 , strokeWidth: 0}}
                className="p-3"
                dot={{r: 4, strokeWidth: 2}}
              />
              <Area
              type="monotone"
              dataKey="pv"
              stroke="var(--color-azul-claro)"
              fill="var(--color-azul-claro)"
              fillOpacity={0.1}
              strokeWidth={3}
               />
            </ComposedChart>
            
          </ChartContainer>
    </Card>
  )
}
