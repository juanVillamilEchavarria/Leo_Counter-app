import { useForm } from "@inertiajs/react"
import { PresupuestoMesActualActions } from "../types/presupuestoMesActual.types"
import { use } from "react"
export default function usePresupuestoMesActualActions<TPayload extends Record<string, any>>() {
    const form = useForm<TPayload>({} as TPayload)

    const duplicate = (id : number)=>{
        form.post(PresupuestoMesActualActions.duplicate(id))
    }
  return {
    duplicate,
    setData : form.setData,
    data: form.data
  }
}
