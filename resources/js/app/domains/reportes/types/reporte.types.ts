import { type Categoria } from "../../categoria"
import { type Cuenta } from "../../cuenta"
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
  mes: string
}
export interface Presupuesto{
    gastado : number
    presupuestado: number
    porcentaje_usado: number
    disponible: number
}

export interface IngresoVsGastosChart {
  data: IngresoVsGastoData[]
  promedios: {
    ingresos: number
    gastos: number
  }
}

export interface BalanceNetoData {
  balance: string
  fecha: string
}

export interface Tendencia {
  ingresos_vs_gastos: IngresoVsGastosChart
  balance_neto_por_fecha: BalanceNetoData[]
  presupuesto: Presupuesto
}



export interface CategoriasDistribucion {
  categoria: string
  cantidad: number
  total: number
}

export interface DistribucionPorCategoria {
  data: CategoriasDistribucion[]
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

export interface ReporteFormOptionsApiReponse{
    categorias: Categoria[]
    cuentas: Cuenta[]
}