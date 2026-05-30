/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import TransitionMotion from "../transitions/TransitionMotion"
import { type TransitionDuration } from "../../types/components"
export default function SectionTransition({
    children,
    transition={
        duration: 0.20
    },
    className = ''
}:{
    children : React.ReactNode
    transition ?: TransitionDuration
    className ?: string
}) {
  return (
    <div className={`section ${className}`}>
        <TransitionMotion
        active
        initial={{ opacity: 0, y: 6 }}
        transition={transition}
        >
            {children}
        </TransitionMotion>
    </div>
  )
}
