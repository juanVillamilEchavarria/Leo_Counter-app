import { useCallback, useState } from "react"
export function useModalItem<T>() {
  const [item, setItem] = useState<T | null>(null)
  const [modal, setModal] = useState<string | null>(null)

  const open = useCallback((item: T, modal: string) => {
    setItem(item)
    setModal(modal)
  }, [])

  const close = useCallback(() => {
    setItem(null)
    setModal(null)
  }, [])

  return {
    item,
    modal,
    open,
    close,
    setItem,
    setModal
  }
}