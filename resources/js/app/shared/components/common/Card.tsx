/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type CardProps, CardVariants } from "@/app/shared/types/components"
export default function Card({
    children,
    variant = "primary",
    className="",
    scrollable = false
}:CardProps) {
    const BaseStyles = `
        w-full  
        shadow-md
        rounded-lg 
        p-3`
  return (
    <div className={`
        ${BaseStyles}
        ${CardVariants[variant]}
        ${scrollable ? "overflow-y-scroll" : ""} 
        ${className}
    `}>
        {children}

    </div>
  )
}
