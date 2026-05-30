/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import React from 'react'

export interface FilterOptionProps {
  onClick: () => void
  active: boolean
  output ?: React.ReactNode
}
export default function FilterOption({
  onClick,
  active,
  output

}: FilterOptionProps) {
  return (
     <button
      type="button"
      onClick={onClick}
      className={`px-3 py-1.5 text-sm rounded-md transition-all ${
        active ? "bg-background text-foreground shadow-sm" : "text-muted-foreground hover:bg-background/50"
      }`}
    >
      {output}
    </button>
  )
}
