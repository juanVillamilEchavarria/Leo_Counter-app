import { RadialBarChart, RadialBar, PolarAngleAxis } from "recharts"
import { ChartContainer } from "@/app/shared/components/ui/chart"
import Card from "@/app/shared/components/common/Card"

const chartConfig = {
    value:{
        label: "Presupuesto usado",
        color: "var(--chart-income)",
    }

}
export default function PresupuestoPercentageChart() {

    const value = 45
    const getColor = (value: number)=>{
        if(value <80) return "var(--chart-income)"
        if(value >= 80 && value <=90)return "var(--chart-warning)"
        return "var(--chart-danger)"

    }
  return (
    <Card>
        <div className="flex w-full flex-col gap-2 my-3">
            <div className="flex w-full justify-between">
                <div className="flex flex-col gap-2">
                    <h3 className="font-bold">Presupuesto usado</h3>
                    <p className="text-gray-500 text-sm">Ultimos 6 meses</p>
                </div>
            </div>
         </div>
         <ChartContainer config={chartConfig}>
            <div className="relative flex items-center justify-center">
                <RadialBarChart
                width={350}
                height={350}
                innerRadius="80%"
                outerRadius="100%"
                data={[{ name: "Presupuesto", value: value }]}
                startAngle={90}
                endAngle={-270}
                >
                    <PolarAngleAxis type="number" domain={[0, 100]} tick={false} />
                <RadialBar
                    dataKey="value"
                    fill={getColor(value)}
                    stroke="none"
                    cornerRadius={20}
                    background
                />
               
            </RadialBarChart>
             <div className="absolute flex flex-col items-center justify-center">
                        <span className="text-3xl font-bold">
                        {value}%
                        </span>
                        <span className="text-xs text-gray-500">
                        usado
                        </span>
                    </div>
            </div>
            
        </ChartContainer>
    </Card>
  )
}
