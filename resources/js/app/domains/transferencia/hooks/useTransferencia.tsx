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
import { useQueryClient } from "@tanstack/react-query";
export default function useTransferencia() {
    const { form, idempotentPost } = useIdempotentForm<TransferenciaFormData>({
        cuenta_origen_id: '',
        cuenta_destino_id: '',
        monto: 0,
        descripcion: '',
    });
    const queryClient = useQueryClient();

    const handleTransferenciaCreate = (e: React.FormEvent) => {
        e.preventDefault();
        form.clearErrors();
        idempotentPost(TransferenciaRoutes.store(), {
        onSuccess: () => {
            queryClient.invalidateQueries({queryKey: ['transferencias']});
            form.reset();
            
        }
    });



    }

    return {
        form,
        handleTransferenciaCreate
    }
}
