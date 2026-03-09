import { apiRequest } from "@/app/shared/api/client.api";
import { type ReporteApiResponse, type ReporteFormOptionsApiReponse } from "../types/reporte.types";

export const reporteApi = async (): Promise<ReporteApiResponse> => {
    return apiRequest<ReporteApiResponse, any>({
        method: 'get',
        url: '/reportes'
    })
}

export const reporteFormOptionsApi = async (): Promise<ReporteFormOptionsApiReponse> =>{
    return apiRequest<ReporteFormOptionsApiReponse, any>({
        method: 'get',
        url: '/reportes/form-options'
    })
}