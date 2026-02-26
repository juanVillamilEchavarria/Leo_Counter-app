import { useMemo, useState } from "react"
import { Pie, PieChart, Cell } from "recharts"
import Card from "@/app/shared/components/common/Card"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/app/shared/components/ui/chart"

type Tipo = "Ingreso" | "Gasto"

const ingresoData = [
  { categoria: "Salario", monto: 65 },
  { categoria: "Freelance", monto: 20 },
  { categoria: "Inversiones", monto: 10 },
  { categoria: "Otros", monto: 5 },
]

const gastoData = [
  { categoria: "Vivienda", monto: 35 },
  { categoria: "Alimentación", monto: 25 },
  { categoria: "Transporte", monto: 15 },
  { categoria: "Salud", monto: 10 },
  { categoria: "Otros", monto: 15 },
]

const pieColors = ["#2563eb", "#16a34a", "#f59e0b", "#dc2626", "#9333ea"]

const chartConfig = {
  monto: { label: "% por categoría", color: "#2563eb" },
} satisfies ChartConfig

export default function CategoriaPieChart() {
  const [tipo, setTipo] = useState<Tipo>("Gasto")

  const data = useMemo(() => (tipo === "Gasto" ? gastoData : ingresoData), [tipo])

  return (
    <Card>
      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h3 className="font-semibold text-lg">Distribución por categoría</h3>
            <p className="text-sm text-gray-500">Selecciona un tipo de movimiento (no ambos)</p>
          </div>
          <div className="inline-flex rounded-xl border border-gray-200 p-1">
            <button
              type="button"
              onClick={() => setTipo("Ingreso")}
              className={`px-3 py-1.5 text-sm rounded-lg transition ${
                tipo === "Ingreso" ? "bg-green-700 text-white" : "text-gray-600 hover:bg-gray-100"
              }`}
            >
              Ingreso
            </button>
            <button
              type="button"
              onClick={() => setTipo("Gasto")}
              className={`px-3 py-1.5 text-sm rounded-lg transition ${
                tipo === "Gasto" ? "bg-red-700 text-white" : "text-gray-600 hover:bg-gray-100"
              }`}
            >
              Gasto
            </button>
          </div>
        </div>

        <ChartContainer config={chartConfig} className="h-[340px]">
          <PieChart>
            <ChartTooltip content={<ChartTooltipContent hideLabel />} />
            <Pie data={data} dataKey="monto" nameKey="categoria" innerRadius={65} outerRadius={115} paddingAngle={3}>
              {data.map((entry, index) => (
                <Cell key={`${entry.categoria}-${index}`} fill={pieColors[index % pieColors.length]} />
              ))}
            </Pie>
          </PieChart>
        </ChartContainer>

        <div className="grid grid-cols-2 md:grid-cols-3 gap-2 text-sm">
          {data.map((entry, index) => (
            <div key={entry.categoria} className="flex items-center gap-2">
              <span
                className="inline-block h-2.5 w-2.5 rounded-full"
                style={{ backgroundColor: pieColors[index % pieColors.length] }}
              />
              <span>{entry.categoria}</span>
              <span className="ml-auto font-semibold">{entry.monto}%</span>
            </div>
          ))}
        </div>
      </div>
    </Card>
  )
}
