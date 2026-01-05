import type React from "react"
import { type TittleProps, TextSize } from "@/app/shared/types/components"

export default function Tittle({
    as: Tag = 'h1',
    tittle,
    size = '2xl',
    className=''
}:TittleProps) {
    
  return (
    <Tag className={`font-bold ${TextSize[size]} ${className}`}>{tittle}</Tag>
  )
}
