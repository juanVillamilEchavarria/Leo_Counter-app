/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useForm } from "@inertiajs/react"
import { PresupuestoMesActualActions } from "../types/presupuestoMesActual.types"
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
