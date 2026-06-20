/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */

import { route } from "ziggy-js"

/**
 * Rutas web de Auditoría (Ziggy)
 */
export const AuditoriaRoutes = {
    index: () => route('auditorias.index')
}

/**
 * Acciones API para Auditoría
 */
export const AuditoriaApiActions = {
    // Endpoint server-side que devuelve la paginación (debe coincidir con routes/api.php)
    paginatedData: '/auditorias'
}

/**
 * Interfaz que representa un registro de auditoría tal como lo devuelve el backend.
 */
export type Auditoria = {
    id: string,
    user: string | null,
    auditable_type: string,
    auditable_id: string | null,
    action: string,
    created_at: string,
    old_values: Record<string, any> | null,
    new_values: Record<string, any> | null
}

/**
 * Tipo usado por la tabla (misma estructura en este caso).
 */
export type AuditoriaTableData = Auditoria
