import { useCallback} from "react"
import { useMyDropZone, useFilePreviewList } from "@/app/shared/hooks"
import useMovimientoPendienteActions from "./useMovimientoPendienteActions"
import {useSubmitWithId} from "@/app/shared/hooks"
import {  type UseMarkAsDoneParams } from "../types/movimientoPendiente.types"
import { type MarkAsDonePayload } from "../types/movimientoPendiente.types"

export default function useMarkAsDone({
    onClose,
    onSubmit,
    itemSelected,
}: UseMarkAsDoneParams) {
    const {markAsDone, setData, data: formFiles}= useMovimientoPendienteActions<MarkAsDonePayload>() // manejo de archivos
    const {onDrop, onDropRejected, rejectedFiles}= useMyDropZone({
        onFilesChange: (files) => setData('comprobantes', files)
    })
    const handleOnClose = useCallback(() => {
        onClose()
        setData('comprobantes', [])
    }, [onClose, setData])
    const {submit}= useSubmitWithId({
        itemId: itemSelected?.id,
        execute: markAsDone
    })
    const handleMarkAsDone = async (e : React.FormEvent<HTMLFormElement>) => { // el envio del formulario
        e.preventDefault()
        await submit()
        onSubmit()
    }
    const {removeFile: DeleteFile}= useFilePreviewList({
        files: formFiles.comprobantes,
        setFiles : (Files) => setData('comprobantes', Files)
    })
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
