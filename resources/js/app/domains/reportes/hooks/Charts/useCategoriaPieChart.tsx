/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useMemo } from "react"
import useChartMode from "./Filters/useChartMode"
import { type CategoriasDistribution } from "../../types/reporte.types"
import { ChartModesEnum } from "./Filters/useChartMode"

interface useCategoriaPieChartProps {
    data: CategoriasDistribution[]
}
export default function useCategoriaPieChart({
    data
}: useCategoriaPieChartProps) {
 const {mode, filteredOptions}= useChartMode()
   const dataWithPercentages = useMemo(() => {
     const total = data.reduce((acc, item) => acc + item.total, 0)
     return data.map(item => ({
       ...item,
       percentage: total > 0 ? (item.total / total) * 100 : 0
     }))
   }, [data])
 
   const filteredData = useMemo(() => {
     return mode!== ChartModesEnum.AMBOS ? dataWithPercentages.filter(d => d.tipo_movimiento_id === mode ): dataWithPercentages
   }, [mode, dataWithPercentages])

   return {
    filteredData,
    filteredOptions
   }
}
