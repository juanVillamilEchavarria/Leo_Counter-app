/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { route } from "ziggy-js"
import { type Categoria } from "../../categoria"
import { type Cuenta } from "../../cuenta"

export const ReporteApiActions = {
  post: route('api.reportes.generate'),
}

export const ReporteDataSectionId = 'reporte-data-section'

/**
 * Datos del formulario para generar reportes
 * @property cuentas - Array de cuentas seleccionadas para filtrar
 * @property categorias - Array de categorías seleccionadas para filtrar
 * @property startDate - Fecha inicial del período en formato YYYY-MM-DD
 * @property endDate - Fecha final del período en formato YYYY-MM-DD
 * @property only_categorias_fijas - Si true, solo incluye categorías fijas
 */
export interface ReporteFormData {
  cuentas: Cuenta[]
  categorias: Categoria[]
  startDate: string
  endDate: string
  only_categorias_fijas: boolean
}
export interface KPITotales {
  ingresos: number
  gastos: number
  balance_neto: number
  movimientos: number
}

export interface KPIVariaciones {
  ingresos: number | null
  gastos: number | null
  balance_neto: number | null
  movimientos: number | null
}

export interface KPIs {
  totales: KPITotales
  variaciones: KPIVariaciones
}

export interface IngresoVsGastoData {
  ingresos: number
  gastos: number
  period: string
}
export interface Presupuesto{
    gastado : number
    presupuestado: number
    porcentaje_usado: number
    disponible: number
}
export interface IngresoVsGastoPromedios{
  ingresos_por_periodo: number
    gastos_por_periodo: number
    ingresos_por_movimiento: number
    gastos_por_movimiento: number

}
export interface IngresoVsGastoChart {
  data: IngresoVsGastoData[]
  promedios: IngresoVsGastoPromedios
}

export interface BalanceNetoData {
  balance: string
  fecha: string
}

export interface Tendencia {
  ingresos_vs_gastos: IngresoVsGastoChart
  balance_neto_por_fecha: BalanceNetoData[]
  presupuesto: Presupuesto
}



export interface CategoriasDistribution {
  categoria: string
  cantidad: number
  tipo_movimiento_id: number
  total: number
}

export interface DistribucionPorCategoria {
  data: CategoriasDistribution[]
  total_movimientos: number
}

export interface Distribuciones {
  por_categoria: DistribucionPorCategoria
}

export interface ReporteData {
  KPIs: KPIs
  tendencia: Tendencia
  distribuiciones: Distribuciones
}

export interface ReporteApiResponse {
  data: ReporteData
}

interface CategoriaFormOption{
  ingresos: Categoria[]
  gastos: Categoria[]
}


export interface ReporteFormOptionsApiReponse{
  data:{
     categorias: CategoriaFormOption
    cuentas: Cuenta[]
  }
   
}