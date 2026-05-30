/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useFormNormal } from "@/app/shared/hooks"
import { MovimientoEspontaneoActions, type MovimientoEspontaneoFormData } from "../types/movimientoEspontaneo.types"
import { FormMethods } from "@/app/shared/types/components"
import {useIdempotentForm} from "@/app/shared/hooks/form/useIdemptotentForm";

const defaultData: MovimientoEspontaneoFormData = {
    nombre: '',
    cuenta_id: '',
    categoria_id: '',
    tipo_movimiento_id: 1, // o el valor por defecto que prefieras
    monto: 0,
    fecha: '',
    descripcion: '',
    comprobantes: [],
    comprobantes_existing: [],
    comprobantes_delete_ids: [],
};
export default function useMovimientoEspontaneo({
    id,
    data
}:{
    id ?: string | null | undefined
    data ?:  MovimientoEspontaneoFormData
}) {
 const {idempotentPost, idempotentDelete, form}= useIdempotentForm(data ?? defaultData);
 const handleMovimientoPost = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
     form.clearErrors()
    idempotentPost(MovimientoEspontaneoActions.post);
 }

 const handleMovimientoDelete = (e: React.FormEvent<HTMLFormElement>) => {
     if(!id)return
    e.preventDefault();
    form.clearErrors()
    idempotentDelete(MovimientoEspontaneoActions.delete(id));
 }
    return {
     form,
      handleMovimientoPost,
      handleMovimientoDelete
    }
}
