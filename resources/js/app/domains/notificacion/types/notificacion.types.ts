import { type FormCommonProps } from "@/app/shared/types/components"
import { useRoute } from "ziggy-js"
import type { User } from "../../user"
import type {UsuarioForForm} from "@/app/domains/user/types/user.types";
import {createSuscriptorApi, deleteSuscriptorApi} from "@/app/domains/notificacion/api/notificacion.api";

/**
 * Tipos, rutas y acciones para el dominio Notificación (frontend)
 * Sigue el patrón de Cuenta y Categoría: useRoute de ziggy-js,
 * FormCommonProps para formularios, y acciones con claves estándar.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */

const route = useRoute()

// ─── Modelos ────────────────────────────────────────────────

/**
 * Modelo de Canal de Notificación
 */
export interface CanalNotificacion {
  id: string
  nombre: string
  active: boolean
}


/**
 * Modelo de Suscriptor de Notificación
 */
export interface SuscriptorNotificacion {
  id: string
  user_id: string
  canal_notificacion_id: string
  active: boolean
}

export interface SuscriptorTableData extends SuscriptorNotificacion{
    verified: boolean
    user?: { id: string; name: string }
    canal?: CanalNotificacion
}
/** Posibles acciones de la API de suscriptores */
export type SuscriptorApiAction = 'create' | 'delete';

/** Mapa de acciones a funciones API */
export const SuscriptorApiActions = {
    create: (data: SuscriptorFormData) => createSuscriptorApi(data),
    delete: (id: string) => deleteSuscriptorApi(id),
} as const;

// ─── Form Data ──────────────────────────────────────────────

/**
 * Opciones seleccionables del formulario de suscriptor
 */
export interface SuscriptorNotificacionFormOptions {
  usuarios: UsuarioForForm[]
  canales: CanalNotificacion[]
}


export const NotificacionToggleTypes = {
  active: 'active'
} as const



// ─── Acciones (Ziggy) ───────────────────────────────────────

/**
 * Acciones CRUD para suscriptores de notificación.
 * Sigue el patrón estándar: post, put, patch, delete.
 */
export const SuscriptorNotificacionActions = {
  post: route('configuracion.notificaciones.suscriptores.store'),
  delete: (id: string) => route('configuracion.notificaciones.suscriptores.destroy', { suscriptor: id }),
    toggle: (id: string, attribute: string) => route('configuracion.notificaciones.suscriptores.toggle', { suscriptor: id, attribute }),
} as const

/**
 * Acciones de toggle para canales y suscriptores
 */
export const CanalNotificacionActions = {
  toggle: (id: string, attribute: string) => route('configuracion.notificaciones.canales.toggle', { canal: id, attribute }),
} as const
/**
 * Props del formulario de suscriptor.
 * Extiende FormCommonProps (data, setData, errors, submit, processing)
 * y agrega las opciones seleccionables.
 */
export type SuscriptorFormProps = FormCommonProps<SuscriptorFormData> & {
  options: SuscriptorNotificacionFormOptions
}

/**
 * La data que debe manejar el formulario
 */
export interface SuscriptorFormData {
    user_id: string;
    canal_notificacion_id: string;
}
