import { useState } from "react"
import { TiposMovimientoEnum } from "../../../../tipoMovimiento"
/**
 * 
 * @param mode 1: Ingresos, 2: Gastos, 3: Ambos
 */
type ChartMode = 1 | 2 | 3

export const enum ChartModesEnum{
    INGRESO = TiposMovimientoEnum.INGRESO,
    GASTO = TiposMovimientoEnum.GASTO,
    AMBOS = 3
} 

export default function useChartMode() {
      const [mode, setMode] = useState<ChartMode>(ChartModesEnum.AMBOS)
      const filteredOptions=[
    {
      onClick: () => setMode(ChartModesEnum.AMBOS),
      active: mode === ChartModesEnum.AMBOS,
      output: "Ambos",
    },
    {
      onClick: () => setMode(ChartModesEnum.INGRESO),
      active: mode === ChartModesEnum.INGRESO ,
      output: "Ingresos",
    },
    {
      onClick: () => setMode(ChartModesEnum.GASTO),
      active: mode === ChartModesEnum.GASTO,
      output: "Gastos",
    },
  ]

  return {
    mode,
    setMode,
    filteredOptions
  }
}
