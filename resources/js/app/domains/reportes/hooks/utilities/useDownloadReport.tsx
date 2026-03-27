import { useState } from "react"
import { downloadReport } from "../../helpers"
import { toastHelper } from "@/app/shared/helpers"
export default function useDownloadReport() {
const [loading, setLoading] = useState(false)
const download = async () => {
    try {
        setLoading(true)
        toastHelper.info('Descargando reporte...')
        await downloadReport()
        toastHelper.success('Reporte descargado correctamente')
    } catch (error) {
        toastHelper.error('Error al descargar el reporte')
    } finally {
        setLoading(false)
    }
}
return {
    loading,
    download
}
}
