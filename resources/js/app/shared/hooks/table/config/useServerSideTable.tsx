import { useQuery } from "@tanstack/react-query";
import { convertServerSideQueryParams } from "@/app/shared/helpers";
import { ApiMethods, type ServerSideTableResponse } from "@/app/shared/types";
import { apiRequest } from "@/app/shared/api/client.api";
import { type UseServerSideTableProps } from "@/app/shared/types";

export default function useServerSideTable<T extends Record<string, any>>({
    endpoint,
    queryKey,
    params,
    enabled = true
}: UseServerSideTableProps) {
  return useQuery({
    queryKey: [...queryKey, params],
    queryFn:  () =>{ 
            return apiRequest<ServerSideTableResponse<T>, T>({ 
            method: ApiMethods.get,
            url: endpoint,
            params: convertServerSideQueryParams(params)
            })
    },
    enabled,
    placeholderData: (previousData)=> previousData
  })
}
