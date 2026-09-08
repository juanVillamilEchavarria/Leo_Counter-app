import { type CategoriasDistribution } from "../types/reporte.types"
export const calculatePercentagesForCategoryDistribution = (data: CategoriasDistribution[]) => {
  const total = data.reduce((acc, item) => acc + item.total, 0)
  console.log('desde helper', data, total)
  const result = data.map(item => ({
    ...item,
    percentage: total > 0 ? (item.total / total) * 100 : 0
  }))
  console.log('result', result)
  return result
}