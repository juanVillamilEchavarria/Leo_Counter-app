/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useQuery } from "@tanstack/react-query";
import { reporteFormOptionsApi } from "../../api/reporte.api";

export default function useReporteFormOptionsApi() {
 return useQuery({
     queryKey: ['reporte-form-options'],
     queryFn: reporteFormOptionsApi,
     staleTime: 0,
     retry: false
 })
}
