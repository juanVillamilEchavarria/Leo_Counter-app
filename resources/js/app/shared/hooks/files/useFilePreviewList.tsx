import { useCallback, useEffect } from "react"
import { filterItemByIndex } from "@/app/shared/helpers"
import { type FileWithPreview } from "@/app/shared/types"

export function useFilePreviewList({
  files,
  setFiles
}:{
    files: FileWithPreview[] | undefined | null,
  setFiles: (files: FileWithPreview[]) => void
}) {
  const removeFile = useCallback((index: number) => {
    if (!files) return
    setFiles(filterItemByIndex(index, files))
  }, [files, setFiles])

  useEffect(() => {
    return () => {
      files?.forEach(file => URL.revokeObjectURL(file.preview))
    }
  }, [files])

  return {
    removeFile
  }
}
