import { apiRequest } from "@/app/shared/api/client.api";
import { type ReporteApiResponse } from "../types/reporte.types";

export const reporteApi = async (): Promise<ReporteApiResponse> => {
    return apiRequest<ReporteApiResponse, any>({
        method: 'get',
        url: '/reportes'
    })
}