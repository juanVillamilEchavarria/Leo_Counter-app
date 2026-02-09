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
        preview: URL.createObjectURL(file)
      })
    )
    onFilesChange(files)
    setRejectedFiles([])
  }, [onFilesChange])

  const onDropRejected = useCallback((fileRejections: FileRejection[]) => {
    setRejectedFiles(fileRejections)
  }, [])

  return { onDrop, onDropRejected, rejectedFiles }
}

