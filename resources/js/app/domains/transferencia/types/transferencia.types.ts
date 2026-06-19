/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import { useRoute } from "ziggy-js";

export interface Transferencia {
    id: string;
    cuentaOrigen: {
        id: string;
        nombre: string;
    };
    cuentaDestino: {
        id: string;
        nombre: string;
    };
    monto: number;
    descripcion: string;
    fecha: string;
}

export interface TransferenciaFormData {
    cuenta_origen_id: string;
    cuenta_destino_id: string;
    monto: number;
    descripcion: string;
    fecha?: string;
}

const route = useRoute();
export const TransferenciaRoutes = {
    index: () => route('transferencias.index'),
    store: () => route('transferencias.store'),
}

export const TransferenciaApiActions = {
    paginatedData: '/transferencias'
}

import { type FormCommonProps } from "@/app/shared/types/components";

export interface TransferenciaFormProps extends FormCommonProps<TransferenciaFormData> {
    options: {
        cuentas: { id: string, nombre: string }[];
    };
}
