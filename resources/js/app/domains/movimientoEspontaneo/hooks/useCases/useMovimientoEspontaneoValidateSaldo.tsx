import { useApi } from "@/app/shared/hooks"
import { ApiMethods, type ValidateSaldoCuentaData } from "@/app/shared/types"
import { MovimientoEspontaneoAPIActions } from "../../types/movimientoEspontaneo.types"

export default function useMovimientoEspontaneoValidateSaldo({
    cuentaId,
    monto,

}:{
    cuentaId: number,
    monto: number
}) {
    const data = useApi<ValidateSaldoCuentaData>({method: ApiMethods.post, url: MovimientoEspontaneoAPIActions.validateSaldo, data: {id: cuentaId, monto}})
  return {
    data
  }
}
