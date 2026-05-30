/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { apiRequest } from "@/app/shared/api/client.api";
import { type ReporteApiResponse, type ReporteFormOptionsApiReponse, type ReporteFormData } from "../types/reporte.types";

export const reporteApi = async (): Promise<ReporteApiResponse> => {
    return apiRequest<ReporteApiResponse, any>({
        method: 'get',
        url: '/reportes'
    })
}
export const generateReporteApi = async (data: ReporteFormData): Promise<ReporteApiResponse> => {
    return apiRequest<ReporteApiResponse, any>({
        method: 'post',
        url: '/reportes/generate',
        data
    })
}

export const reporteFormOptionsApi = async (): Promise<ReporteFormOptionsApiReponse> =>{
    return apiRequest<ReporteFormOptionsApiReponse, any>({
        method: 'get',
        url: '/reportes/form-options'
    })
}