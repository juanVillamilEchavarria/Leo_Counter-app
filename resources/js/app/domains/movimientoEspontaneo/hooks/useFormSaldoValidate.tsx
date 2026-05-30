/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useQuery } from "@tanstack/react-query"
import { useDebounce } from "use-debounce"
import { useMemo } from "react"
import { saldoValidate } from "../api/saldoValidate"
import { isGasto as isGastoFunc } from "../../tipoMovimiento"
export default function useFormSaldoValidate({
    cuentaId,
    monto,
    tipo_movimiento_id,
    movimiento_id
}:{
    cuentaId?: string | undefined,
    monto?: number | undefined
    tipo_movimiento_id?: number
    movimiento_id?: string | undefined
}) {
    const [debounceMonto] = useDebounce(monto, 500)
    const isGasto = useMemo(() => {
        return isGastoFunc(tipo_movimiento_id)
    }, [tipo_movimiento_id])
    return useQuery({
        queryKey: ['validar-saldo', cuentaId, debounceMonto],
         enabled: !!cuentaId && !!debounceMonto && debounceMonto>0 && isGasto,
        queryFn: () =>{
            if(cuentaId === undefined || debounceMonto === undefined){
                throw new Error('cuentaId y monto son requeridos')

            }
            return saldoValidate({cuentaId, monto: debounceMonto!, movimiento_id})
    },
        staleTime: 0,
        retry: false
    }
    )

}
