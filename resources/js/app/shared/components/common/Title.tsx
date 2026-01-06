import type React from "react"
import { type TitleProps, TextSize } from "@/app/shared/types/components"

export default function Title({
    as: Tag = 'h1',
    title,
    size = '2xl',
    className=''
}:TitleProps) {
    
  return (
    <Tag className={`font-bold ${TextSize[size]} ${className}`}>{title}</Tag>
  )
}
