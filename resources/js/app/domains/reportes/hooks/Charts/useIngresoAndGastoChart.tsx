import { useMemo } from "react"
import useChartMode, {ChartModesEnum} from "./Filters/useChartMode"
import { type IngresoVsGastoData , type IngresoVsGastoPromedios} from "../../types/reporte.types"
interface IngresoAndGastoChartProps {
  data : IngresoVsGastoData[],
  promedios: IngresoVsGastoPromedios
}
export default function useIngresoAndGastoChart({
  data,
  promedios
}: IngresoAndGastoChartProps) {
 const {mode, filteredOptions}= useChartMode()
 
   const title = useMemo(() => {
     if (mode === ChartModesEnum.INGRESO) return "Ingresos mensuales"
     if (mode === ChartModesEnum.GASTO) return "Gastos mensuales"
     return "Ingresos vs Gastos"
   }, [mode])
 
 
   /**
    * Filtra los datos para mostrar solo los ingresos o los gastos
    */
   const filteredData = useMemo(() => {
     return data.map(item => ({
       period: item.period,
       ingresos: mode === ChartModesEnum.GASTO ? 0 : item.ingresos,
       gastos: mode === ChartModesEnum.INGRESO ? 0 : item.gastos,
     }))
   }, [mode, data])
 
   const displayedPromedios = useMemo(() => {
     return {
       ingresos_por_periodo: mode === ChartModesEnum.GASTO ? 0 : promedios.ingresos_por_periodo,
       gastos_por_periodo: mode === ChartModesEnum.INGRESO ? 0 : promedios.gastos_por_periodo,
       ingresos_por_movimiento: mode === ChartModesEnum.GASTO ? 0 : promedios.ingresos_por_movimiento,
       gastos_por_movimiento: mode === ChartModesEnum.INGRESO ? 0 : promedios.gastos_por_movimiento,
     }
   }, [mode, promedios])
   return {
    title,
    mode,

    filteredData,
    displayedPromedios,
    filteredOptions
   }
}
