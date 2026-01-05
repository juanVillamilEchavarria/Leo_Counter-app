import { useState } from "react"

export default function useOpen(open : boolean) {
 const [isOpen, setIsOpen] = useState(open)
  return {
    isOpen,
    setIsOpen
 }
}
