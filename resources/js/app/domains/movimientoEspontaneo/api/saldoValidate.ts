import { apiRequest } from "@/app/shared/api/client.api";
import { ApiMethods, type SaldoValidateResponse } from "@/app/shared/types";
import { MovimientoEspontaneoAPIActions } from "../types/movimientoEspontaneo.types";

export const saldoValidate = async ({
    cuentaId,
    monto,
    movimiento_id
}: {
    cuentaId: string;
    monto: number;
    movimiento_id?: string | undefined
}): Promise<SaldoValidateResponse> => {
    return apiRequest<SaldoValidateResponse, any>({
        method: ApiMethods.post,
        url: MovimientoEspontaneoAPIActions.validateSaldo,
        data: { cuenta_id: cuentaId, monto, movimiento_id }
    });
}
