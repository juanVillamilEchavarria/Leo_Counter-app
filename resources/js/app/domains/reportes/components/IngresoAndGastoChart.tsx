import { useMemo, useState } from "react"
import { Bar, BarChart, CartesianGrid, XAxis, YAxis } from "recharts"
import Card from "@/app/shared/components/common/Card"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  type ChartConfig,
} from "@/app/shared/components/ui/chart"

type ChartMode = "ambos" | "ingresos" | "gastos"

const data = [
  { month: "Ene", ingresos: 1800, gastos: 1200 },
  { month: "Feb", ingresos: 2200, gastos: 1650 },
  { month: "Mar", ingresos: 2100, gastos: 1400 },
  { month: "Abr", ingresos: 2400, gastos: 1900 },
  { month: "May", ingresos: 2600, gastos: 1700 },
  { month: "Jun", ingresos: 2500, gastos: 1600 },
]

const chartConfig = {
  ingresos: {
    label: "Ingresos",
    color: "#16a34a",
  },
  gastos: {
    label: "Gastos",
    color: "#dc2626",
  },
} satisfies ChartConfig

export default function IngresoAndGastoChart() {
  const [mode, setMode] = useState<ChartMode>("ambos")

  const title = useMemo(() => {
    if (mode === "ingresos") return "Ingresos mensuales (últimos 6 meses)"
    if (mode === "gastos") return "Gastos mensuales (últimos 6 meses)"
    return "Ingresos vs gastos (últimos 6 meses)"
  }, [mode])

  return (
    <Card>
      <div className="flex flex-col gap-4">
        <div className="flex flex-wrap items-center justify-between gap-3">
          <div>
            <h3 className="font-semibold text-lg">{title}</h3>
            <p className="text-sm text-gray-500">Visualización estática para maquetación UI</p>
          </div>

          <div className="inline-flex rounded-xl border border-gray-200 p-1">
            <button
              type="button"
              onClick={() => setMode("ambos")}
              className={`px-3 py-1.5 text-sm rounded-lg transition ${
                mode === "ambos" ? "bg-gray-900 text-white" : "text-gray-600 hover:bg-gray-100"
              }`}
            >
              Ambos
            </button>
            <button
              type="button"
              onClick={() => setMode("ingresos")}
              className={`px-3 py-1.5 text-sm rounded-lg transition ${
                mode === "ingresos" ? "bg-green-700 text-white" : "text-gray-600 hover:bg-gray-100"
              }`}
            >
              Ingresos
            </button>
            <button
              type="button"
              onClick={() => setMode("gastos")}
              className={`px-3 py-1.5 text-sm rounded-lg transition ${
                mode === "gastos" ? "bg-red-700 text-white" : "text-gray-600 hover:bg-gray-100"
              }`}
            >
              Gastos
            </button>
          </div>
        </div>

        <ChartContainer config={chartConfig}>
          <BarChart data={data} barCategoryGap={24}>
            <CartesianGrid vertical={false} strokeDasharray="4 4" />
            <XAxis dataKey="month" tickLine={false} axisLine={false} />
            <YAxis tickLine={false} axisLine={false} width={42} />
            <ChartTooltip cursor={false} content={<ChartTooltipContent />} />

            {(mode === "ambos" || mode === "ingresos") && (
              <Bar dataKey="ingresos" fill="var(--color-ingresos)" radius={6} />
            )}
            {(mode === "ambos" || mode === "gastos") && (
              <Bar dataKey="gastos" fill="var(--color-gastos)" radius={6} />
            )}
          </BarChart>
        </ChartContainer>
      </div>
    </Card>
  )
}
