import { apiRequest } from "@/app/shared/api/client.api";
import { type HomeApiResponse } from "../types/home.types";

const ENDPOINTS={
    home : '/home'
}
export const homeApi = async () : Promise<HomeApiResponse>=>{
    return apiRequest<HomeApiResponse, any>({
        method: 'get',
        url: ENDPOINTS.home
    })
}