/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { apiRequest } from "@/app/shared/api/client.api";
import type {SuscriptorNotificacionFormOptions} from "@/app/domains/notificacion";
import type {SuscriptorFormData} from "@/app/domains/notificacion";

/**
 * Respuesta de la creación / actualización de un suscriptor
 */
export interface SuscriptorApiResponse {
    id: string;
}
/**
 * Obtiene las opciones para el formulario de suscriptor de notificación
 * @returns {Promise<SuscriptorNotificacionFormOptions>}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export const suscriptorNotificacionFormOptionsApi = async () : Promise<SuscriptorNotificacionFormOptions> =>{

    return apiRequest<SuscriptorNotificacionFormOptions, any>({
        method: 'get',
        url: 'notificacion/suscriptores/form-options'
    })
}
/** Crear un suscriptor  */
export const createSuscriptorApi = async (data: SuscriptorFormData): Promise<SuscriptorApiResponse> => {
    return apiRequest<SuscriptorApiResponse, any>({
        method: 'post',
        url: 'notificacion/suscriptores',
        data
    });
};


/** Eliminar suscriptor */
export const deleteSuscriptorApi = async (id: string): Promise<void> => {
    return apiRequest<void, any>({
        method: 'delete',
        url: `notificacion/suscriptores/${id}`
    });
};
