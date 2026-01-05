export type TransitionSection={
    opacity: number,
    y?: number,
    x?: number,
    scaleY?: number,
    scaleX?: number,
    transformOrigin?: string
}
export type TransitionDuration={
    duration: number
}
export type TransitionMotionProps={
    active: boolean,
    children: React.ReactNode,
    className?: string  
    layout?: boolean | "size" | "position" | "preserve-aspect" ,
    initial?: TransitionSection,
    animate?: TransitionSection,
    exit?: TransitionSection,
    transition?: TransitionDuration
}