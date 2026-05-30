/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
    setFiles(filterItemByIndex(index, files)) // se llama al helper que elimina el item del array de archivos
  }, [files, setFiles])

  useEffect(() => {
    return () => {
      files?.forEach(file => URL.revokeObjectURL(file.preview)) // se revocan las urls
    }
  }, [files])

  return {
    removeFile
  }
}
