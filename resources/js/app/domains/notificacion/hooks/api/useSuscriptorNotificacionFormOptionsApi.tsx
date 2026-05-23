import {useQuery, type UseQueryResult} from "@tanstack/react-query";
import {suscriptorNotificacionFormOptionsApi} from "@/app/domains/notificacion/api/notificacion.api";
import type {SuscriptorNotificacionFormOptions} from "@/app/domains/notificacion";


/**
 * Hook para obtener las opciones para el formulario de suscriptor de notificación
 * @returns {Object} Objeto con la información de los usuarios y canales
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
export default function useSuscriptorNotificacionFormOptionsApi({
    enabled
}:{
    enabled: boolean
}) :UseQueryResult<SuscriptorNotificacionFormOptions> {
    return useQuery({
        queryKey: ['suscriptor-notificaciones-form-options'],
        queryFn: () => suscriptorNotificacionFormOptionsApi(),
        enabled: enabled,
        staleTime: 0,
        retry : false,

    });
}
