import { useFilePreviewList, useMyDropZone} from "@/app/shared/hooks"
import { useCallback } from "react"
import { type FileWithPreview } from "@/app/shared/types"
export default function useMovimientoEspontaneoUploadFiles({
    setFiles,
    files
}:{
    files: FileWithPreview[] | undefined | null,
    setFiles: (files: FileWithPreview[]) => void
}) {
  const {onDrop, onDropRejected, rejectedFiles}= useMyDropZone({ // llamamos al hook que orquesta la subida de los archivos
    onFilesChange: (files) => setFiles(files)
  })

  const {removeFile}= useFilePreviewList({ //llamamos al hook que orquesta la eliminacion de los archivos
    files,
    setFiles
  })

  return {
    onDrop,
    onDropRejected,
    rejectedFiles,
    removeFile
  }
}
