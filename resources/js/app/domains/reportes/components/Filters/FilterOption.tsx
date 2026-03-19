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
        active ? "bg-white text-gray-900 shadow-sm" : "text-gray-600 hover:bg-white/50"
      }`}
    >
      {output}
    </button>
  )
}
