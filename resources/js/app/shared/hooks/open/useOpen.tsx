/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { useState } from "react"

export default function useOpen(open : boolean) {
 const [isOpen, setIsOpen] = useState(open)
  return {
    isOpen,
    setIsOpen
 }
}
