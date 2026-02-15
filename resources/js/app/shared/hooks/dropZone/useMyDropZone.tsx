import { useState, useCallback } from "react"
import { type FileRejection } from "react-dropzone"
import { type FileWithPreview } from "../../types"
export default function useMyDropZone<T extends string>({
  onFilesChange
}:{
  onFilesChange: (files: FileWithPreview[]) => void
}) {
  const [rejectedFiles, setRejectedFiles] = useState<FileRejection[]>([])

  const onDrop = useCallback((acceptedFiles: File[]) => {
    const files = acceptedFiles.map(file =>
      Object.assign(file, {
        preview: URL.createObjectURL(file) // para cada archivo se crea una url del preview
      })
    )
    onFilesChange(files) // luego se setean los archivos
    setRejectedFiles([]) // se limpian los archivos rechazados
  }, [onFilesChange])

  const onDropRejected = useCallback((fileRejections: FileRejection[]) => {
    console.log(fileRejections)
    setRejectedFiles(fileRejections) // cuando se rechazan archivos se setean
  }, [])

  return { onDrop, onDropRejected, rejectedFiles }
}

