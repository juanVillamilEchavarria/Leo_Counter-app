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
