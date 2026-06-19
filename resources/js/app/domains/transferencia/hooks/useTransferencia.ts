/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import { useIdempotentForm } from "@/app/shared/hooks/form/useIdemptotentForm";
import { type TransferenciaFormData, TransferenciaRoutes } from "../types/transferencia.types";

export default function useTransferencia() {
    const { form, idempotentPost } = useIdempotentForm<TransferenciaFormData>({
        cuenta_enviadora_id: '',
        cuenta_receptora_id: '',
        monto: 0,
        descripcion: '',
    });

    const handleTransferenciaCreate = (e: React.FormEvent) => {
        e.preventDefault();
        idempotentPost(TransferenciaRoutes.store(), {
            onSuccess: () => {
                form.reset();
            }
        });
    }

    return {
        form,
        handleTransferenciaCreate
    }
}
