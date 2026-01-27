import TransitionMotion from "../transitions/TransitionMotion"
import { type TransitionDuration } from "../../types/components"
export default function SectionTransition({
    children,
    transition={
        duration: 0.20
    }
}:{
    children : React.ReactNode
    transition ?: TransitionDuration
}) {
  return (
    <div className="section">
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
