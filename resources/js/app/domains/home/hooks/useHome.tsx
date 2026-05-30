/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { homeApi } from "../api/home.api"
import { useQuery } from "@tanstack/react-query"
export default function useHome() {
    return useQuery({
        queryKey: ['home'],
        queryFn: homeApi,
        staleTime: 0,   
        retry: false
    })
}
