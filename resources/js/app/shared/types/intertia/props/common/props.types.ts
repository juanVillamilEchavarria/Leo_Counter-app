/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type User } from "@/app/domains/user"
export type InertiaProps = {
    errors?: Record<string, string>,
    auth?: {
        user?: User
    }
    title?: string,
    NoRegistros?: number
}