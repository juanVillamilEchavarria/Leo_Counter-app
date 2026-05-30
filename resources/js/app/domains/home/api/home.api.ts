/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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