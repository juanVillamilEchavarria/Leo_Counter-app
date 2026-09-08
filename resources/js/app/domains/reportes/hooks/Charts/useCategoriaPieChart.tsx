/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useEffect, useMemo } from "react"
import useChartMode from "./Filters/useChartMode"
import { type CategoriasDistribution } from "../../types/reporte.types"
import { ChartModesEnum } from "./Filters/useChartMode"
import { calculatePercentagesForCategoryDistribution } from "../../helpers/statistic.helper"
import { useState } from "react"

interface useCategoriaPieChartProps {
    data: CategoriasDistribution[]
}

interface FilteredData extends CategoriasDistribution{
    percentage: number

}
export default function useCategoriaPieChart({
    data
}: useCategoriaPieChartProps) {
 const {mode, filteredOptions}= useChartMode()
  const [filteredData, setFilteredData]= useState<FilteredData[]>(calculatePercentagesForCategoryDistribution(data))
  useEffect(()=>{ 
    
    const newData =  mode!== ChartModesEnum.AMBOS ? data.filter(d => d.tipo_movimiento_id === mode ): data
    const filtered = calculatePercentagesForCategoryDistribution(newData)
    setFilteredData(filtered)
  },[mode])

   return {
    filteredData,
    filteredOptions
   }
}
