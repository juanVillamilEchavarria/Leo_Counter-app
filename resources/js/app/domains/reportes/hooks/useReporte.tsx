import { useFormNormal } from "@/app/shared/hooks"
import { type ReporteFormData, ReporteApiActions } from "../types/reporte.types"
export default function useReporte({
    data
}:{
    data ?: ReporteFormData
}) { 
    const {form, submit, handleSubmit} = useFormNormal<ReporteFormData>({
        action: ReporteApiActions.post,
        data: data ?? {
            cuentas: [],
            categorias: [],
            startDate: '',
            endDate: '',
            only_categorias_fijas: false
        }
    })
    return {
        form,
        submit,
        handleSubmit
    }
}
