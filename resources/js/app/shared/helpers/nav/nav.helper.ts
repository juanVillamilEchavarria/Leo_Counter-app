/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useRoute } from "ziggy-js";
const route= useRoute()
export function isRouteActive ( routeName : string | string[] | undefined): boolean {
    if(!routeName)return false

    if(Array.isArray(routeName)){
        return routeName.some((r) => route().current(r))
    }

    return route().current(routeName)

}
