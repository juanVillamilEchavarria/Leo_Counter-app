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
