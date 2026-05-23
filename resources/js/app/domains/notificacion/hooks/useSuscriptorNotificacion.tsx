import { useForm } from "@inertiajs/react";
import type { SuscriptorFormData } from "../types/notificacion.types"

/**
 * Hook simplificado para manejo de formulario de Suscriptor de Notificación.
 * Sólo soporta creación (store). No recibe datos de edición.
 *
 * @returns {object} form - instancia de useForm de Inertia para manipulación del formulario
 */
export default function useSuscriptorNotificacion() {
  const initialData ={
    user_id: '',
    canal_notificacion_id: ''
  }
  const form  = useForm<SuscriptorFormData>(initialData);
  return { form }
}
