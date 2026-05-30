/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type KPIs, type Tendencia} from "../../reportes/types/reporte.types";
/**
 * Respuesta de la API de home
 * @param KPIs - Indicadores clave de rendimiento
 * @param tendencias - Trae la tendencia de balance neto
 */

export interface HomeData{
    KPIs: KPIs
    tendencia: Pick<Tendencia,  'ingresos_vs_gastos'>
}
export interface HomeApiResponse{
   data: HomeData
}