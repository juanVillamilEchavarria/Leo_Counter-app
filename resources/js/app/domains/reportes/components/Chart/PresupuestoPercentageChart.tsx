import { RadialBarChart, RadialBar, PolarAngleAxis } from "recharts"
import { ChartContainer } from "@/app/shared/components/ui/chart"
import Card from "@/app/shared/components/common/Card"
import EmptyDataMessage from "../common/EmptyDataMessage"
import {type Presupuesto } from "../../types/reporte.types"
import { moneyFormat } from "@/app/shared/helpers"

const chartConfig = {
    presupuesto:{
        label: "Presupuesto usado",
        color: "var(--chart-income)",
    }

}

interface PresupuestoPercentageChartProps {
    data: Presupuesto
}
export default function PresupuestoPercentageChart({
    data
}: PresupuestoPercentageChartProps) {
    const getColor = (value: number)=>{
        if(data.porcentaje_usado <80) return "var(--chart-income)"
        if(data.porcentaje_usado >= 80 && data.porcentaje_usado <=90)return "var(--chart-warning)"
        return "var(--chart-danger)"

    }
    const hasBudget = data.presupuestado > 0

  return (
    <Card>
        <div className="flex w-full flex-col gap-3 my-3">
            <div className="flex w-full justify-between items-start">
                <div className="flex flex-col gap-1">
                    <h3 className="font-bold text-lg">Control Presupuestario</h3>
                    <p className="text-muted-foreground text-sm">Estado del presupuesto mensual</p>
                </div>
                {hasBudget && (
                    <div className="text-right">
                        <span className={`text-sm font-semibold px-2 py-1 rounded-full ${
                            data.porcentaje_usado < 80 ? 'bg-green-100 text-green-800' :
                            data.porcentaje_usado <= 90 ? 'bg-yellow-100 text-yellow-800' :
                            'bg-red-100 text-red-800'
                        }`}>
                            {data.porcentaje_usado.toFixed(1)}% usado
                        </span>
                    </div>
                )}
            </div>

            {hasBudget ? (
                <>
                    <div className="grid grid-cols-3 gap-4 text-sm">
                        <div className="text-center">
                            <p className="text-muted-foreground">Presupuestado</p>
                            <p className="font-semibold text-gray-900">{moneyFormat(data.presupuestado)}</p>
                        </div>
                        <div className="text-center">
                            <p className="text-muted-foreground">Gastado</p>
                            <p className="font-semibold text-red-600">{moneyFormat(data.gastado)}</p>
                        </div>
                        <div className="text-center">
                            <p className="text-muted-foreground">Disponible</p>
                            <p className={`font-semibold ${data.disponible >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                                {moneyFormat(Math.abs(data.disponible))}
                            </p>
                        </div>
                    </div>

                    <ChartContainer config={chartConfig} className="h-[200px]">
                        <div className="relative flex items-center justify-center">
                            <RadialBarChart
                            width={200}
                            height={200}
                            innerRadius="70%"
                            outerRadius="90%"
                            data={[data]}
                            startAngle={90}
                            endAngle={-270}
                            >
                                <PolarAngleAxis type="number" domain={[0, 100]} tick={false} />
                            <RadialBar
                                dataKey="porcentaje_usado"
                                fill={getColor(data.porcentaje_usado)}
                                stroke="none"
                                cornerRadius={20}
                                background
                            />

                        </RadialBarChart>
                         <div className="absolute flex flex-col items-center justify-center">
                                    <span className="text-2xl font-bold">
                                    {data.porcentaje_usado.toFixed(1)}%
                                    </span>
                                    <span className="text-xs text-muted-foreground">
                                    usado
                                    </span>
                                </div>
                        </div>
                    </ChartContainer>
                </>
            ) : (
                <EmptyDataMessage
                    paragraph="Agrega un presupuesto para visualizar el control presupuestario"
                />
            )}
        </div>
    </Card>
  )
}
