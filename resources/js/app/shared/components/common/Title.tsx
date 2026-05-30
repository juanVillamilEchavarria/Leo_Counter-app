/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import type React from "react"
import { type TitleProps, TextSize } from "@/app/shared/types/components"

export default function Title({
    as: Tag = 'h1',
    title,
    size = '2xl',
    className=''
}:TitleProps) {
    
  return (
    <Tag className={`text-foreground font-bold ${TextSize[size]} ${className}`}>{title}</Tag>
  )
}
