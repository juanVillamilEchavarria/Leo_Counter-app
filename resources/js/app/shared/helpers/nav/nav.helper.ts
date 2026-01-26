import { useRoute } from "ziggy-js";
const route= useRoute()
export function isRouteActive ( routeName : string | string[] | undefined): boolean {
    if(!routeName)return false

    if(Array.isArray(routeName)){
        return routeName.some((r) => route().current(r))
    }

    return route().current(routeName)

}
