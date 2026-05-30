/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
