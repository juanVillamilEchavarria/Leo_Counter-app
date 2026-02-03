import { useCallback, useState, useEffect } from "react"
import useMovimientoPendienteActions from "../hooks/useMovimientoPendienteActions"
import { type MovimientoPendienteTableData, type UseMarkAsDoneParams } from "../types/movimientoPendiente.types"
import { type MarkAsDonePayload } from "../types/movimientoPendiente.types"
import { type FileWithPreview } from "@/app/shared/types"
import { type FileRejection } from "react-dropzone"
export default function useMarkAsDone({
    onClose,
    onSubmit,
    itemSelected,
}: UseMarkAsDoneParams) {
    const {markAsDone, setData, data: formFiles}= useMovimientoPendienteActions<MarkAsDonePayload>() // manejo de archivos
    const [rejectedFiles, setRejectedFiles] = useState<FileRejection[]>([]) // manejo de archivos con errores
    const onDrop = useCallback((acceptedFiles : File[]) => { // onDrop
        const files : FileWithPreview[] = acceptedFiles.map(file => 
            Object.assign(file, {
            preview: URL.createObjectURL(file)
            })
        )
        setData('comprobantes', files)
        setRejectedFiles([])
    }, [])
    const onDropRejected = useCallback((fileRejections: FileRejection[]) => {
    setRejectedFiles(fileRejections)
    }, [])

    const handleOnClose = useCallback(() => {
        onClose()
        setData('comprobantes', [])
    }, [onClose, setData])


    const handleMarkAsDone = async (e : React.FormEvent<HTMLFormElement>) => { // el envio del formulario
        e.preventDefault()
        if(!itemSelected) return 
        await markAsDone(itemSelected.id)
        onSubmit()
    }
    const DeleteFile = (index: number) => { // para eliminar determiando archivo
    if(!formFiles.comprobantes) return
    const updated = formFiles.comprobantes.filter((_, i) => i !== index)
    setData('comprobantes', updated)
    }
    useEffect(() => {
        return () => {
            formFiles.comprobantes?.forEach(file => {
            URL.revokeObjectURL(file.preview)
            })
        }
    }, [formFiles.comprobantes])
  return {
    onDrop,
    onDropRejected,
    handleOnClose,
    handleMarkAsDone,
    rejectedFiles,
    DeleteFile,
     formFiles,
    setData
  }
}
