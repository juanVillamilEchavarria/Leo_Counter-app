/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
