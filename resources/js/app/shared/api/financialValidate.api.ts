/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
import { apiRequest } from "@/app/shared/api/client.api";
import { ApiMethods, type SaldoValidateResponse } from "@/app/shared/types";
import { SaldoValidateApiActions } from "../types/api";

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
        url: SaldoValidateApiActions.validateSaldo,
        data: { cuenta_id: cuentaId, monto, movimiento_id }
    });
}
