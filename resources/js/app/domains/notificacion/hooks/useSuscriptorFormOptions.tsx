/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import useSuscriptorNotificacionFormOptionsApi from "./api/useSuscriptorNotificacionFormOptionsApi";
import { useEffect, useState } from "react";
import type { SuscriptorNotificacionFormOptions } from "../types/notificacion.types";
/**
 * Hook que maneja el estado de las opciones del formulario de suscriptor de notificación.
 * Obtiene las opciones desde el API cuando el modal se abre, y las almacena en el estado local.
 * Esto permite que el formulario tenga acceso a las opciones actualizadas cada vez que se abre.
 * @param param0 
 */

export default function useSuscriptorFormOptions({
    open
}:{
    open: boolean
}) {
   const { data: optionsData } = useSuscriptorNotificacionFormOptionsApi({ enabled: open });
      const [options, setOptions] = useState<SuscriptorNotificacionFormOptions>({} as SuscriptorNotificacionFormOptions);
      useEffect(() => {
          if (optionsData) {
              setOptions({
                  canales: optionsData.canales || [],
                  usuarios: optionsData.usuarios || []
              });
          }
      }, [optionsData]);

        return {
            options
        }
}
