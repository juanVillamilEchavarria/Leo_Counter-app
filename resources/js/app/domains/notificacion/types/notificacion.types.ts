import { type FormCommonProps } from "@/app/shared/types/components"
import { useRoute } from "ziggy-js"
import type { User } from "../../user"
import type {UsuarioForForm} from "@/app/domains/user/types/user.types";
import {createSuscriptorApi, updateSuscriptorApi, deleteSuscriptorApi} from "@/app/domains/notificacion/api/notificacion.api";

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
  activo: boolean
}


/**
 * Modelo de Suscriptor de Notificación
 */
export type SuscriptorNotificacion = {
  id: string
  user_id: string
  canal_notificacion_id: string
  activo: boolean
  user?: { id: string; name: string }
  canal?: CanalNotificacion
}
/** Posibles acciones de la API de suscriptores */
export type SuscriptorApiAction = 'create' | 'update' | 'delete';

/** Mapa de acciones a funciones API */
export const SuscriptorApiActions = {
    create: (data: SuscriptorFormData) => createSuscriptorApi(data),
    update: (id: string, data: Partial<SuscriptorFormData>) => updateSuscriptorApi(id, data),
    delete: (id: string) => deleteSuscriptorApi(id),
} as const;

// ─── Form Data ──────────────────────────────────────────────

/**
 * Datos del formulario de suscriptor (campos enviados al backend)
 */
export type SuscriptorNotificacionFormData = Pick<
  SuscriptorNotificacion,
  'user_id' | 'canal_notificacion_id' | 'activo'
>

/**
 * Opciones seleccionables del formulario de suscriptor
 */
export interface SuscriptorNotificacionFormOptions {
  usuarios: UsuarioForForm[]
  canales: CanalNotificacion[]
}


export const NotificacionToggleTypes = {
  activo: 'activo'
} as const


/**
 * Rutas de navegación del dominio Notificación
 */
export const NotificacionRoutes = {
  canalesIndex: () => route('configuracion.notificaciones.canales.index'),
  suscriptoresIndex: () => route('configuracion.notificaciones.suscriptores.index')
}

// ─── Acciones (Ziggy) ───────────────────────────────────────

/**
 * Acciones CRUD para suscriptores de notificación.
 * Sigue el patrón estándar: post, put, patch, delete.
 */
export const SuscriptorNotificacionActions = {
  post: route('configuracion.notificaciones.suscriptores.store'),
  put: (id: string) => route('configuracion.notificaciones.suscriptores.update', { suscriptor: id }),
  patch: (id: string) => route('configuracion.notificaciones.suscriptores.update', { suscriptor: id }),
  delete: (id: string) => route('configuracion.notificaciones.suscriptores.destroy', { suscriptor: id }),
} as const

/**
 * Acciones de toggle para canales y suscriptores
 */
export const NotificacionToggleActions = {
  toggleSuscriptor: (id: string, attribute: string) => route('configuracion.notificaciones.suscriptores.toggle', { suscriptor: id, attribute }),
  toggleCanal: (id: string, attribute: string) => route('configuracion.notificaciones.canales.toggle', { canal: id, attribute }),
} as const
/**
 * Props del formulario de suscriptor.
 * Extiende FormCommonProps (data, setData, errors, submit, processing)
 * y agrega las opciones seleccionables.
 */
export type SuscriptorFormProps = FormCommonProps<SuscriptorNotificacionFormData> & {
  options: SuscriptorNotificacionFormOptions
}

/**
 * La data que debe manejar el formulario
 */
export interface SuscriptorFormData {
    user_id: string;
    canal_notificacion_id: string;
}
