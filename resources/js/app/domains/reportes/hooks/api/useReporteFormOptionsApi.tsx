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
