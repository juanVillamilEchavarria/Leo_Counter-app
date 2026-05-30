/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useCallback, useState } from "react"
export function useModalItem<T>() {
  const [item, setItem] = useState<T | null>(null)
  const [modal, setModal] = useState<string | null>(null)

  const open = useCallback((item: T | null, modal: string) => {
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
