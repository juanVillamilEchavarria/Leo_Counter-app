import { apiRequest } from "../../api/client.api"
import {  type ApiParams } from "../../types"
export default function useApi<TData extends Record<string,any>>({
    method = 'post',
    url,
    data,
    params
}:ApiParams<TData>) {
  const responseData = apiRequest({
    method,
    url,
    data,
    params
  })
  return responseData
}
