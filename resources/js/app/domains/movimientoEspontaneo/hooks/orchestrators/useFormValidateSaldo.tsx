import { useQuery } from "@tanstack/react-query"
import { useDebounce } from "use-debounce"
import useMovimientoEspontaneoValidateSaldo from "../useCases/useMovimientoEspontaneoValidateSaldo"
export default function useFormValidateSaldo({
    cuentaId,
    monto,
}:{
    cuentaId?: number | undefined,
    monto?: number | undefined
}) {
    const [debounceMonto] = useDebounce(monto, 500)
    return useQuery({
        queryKey: ['validar-saldo', cuentaId, debounceMonto],
         enabled: !!cuentaId && !!debounceMonto && debounceMonto>0,
        queryFn: () =>{ 
            if(cuentaId === undefined || debounceMonto === undefined){
                throw new Error('cuentaId y monto son requeridos')

            }
            return useMovimientoEspontaneoValidateSaldo({cuentaId, monto: debounceMonto!})
    },
        staleTime: 0,
        retry: false
    }
    )
  
}
