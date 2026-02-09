import AxiosClient from "@/config/api/axios";
import {type ApiParams } from "../types";

export const apiRequest = async<TResponse, TData extends Record<string,any>>({
    method = 'post',
    url,
    data,
    params
}:ApiParams<TData>) : Promise<TResponse>=>{
    const response = await AxiosClient.request({
        method,
        url,
        data,
        params
    })
    return response.data

}