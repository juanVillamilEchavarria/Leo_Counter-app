import { useForm } from "@inertiajs/react"
import { MovimientoPendienteActions } from "../types/movimientoPendiente.types"
export default function useMovimientoPendienteActions<TPayload extends Record<string, any>>() {
    const form = useForm<TPayload>({} as TPayload)

    const markAsDone = (id: number) => {
        form.patch(MovimientoPendienteActions.markAsDone(id))
    }
    return {
        markAsDone,
        setData : form.setData,
        data: form.data
    }
}
