/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
    ease?: [number, number, number, number]
}
export type TransitionMotionProps={
    active: boolean | string | number| undefined,
    children: React.ReactNode,
    className?: string  
    style?: React.CSSProperties
    layout?: boolean | "size" | "position" | "preserve-aspect" ,
    initial?: TransitionSection,
    animate?: TransitionSection,
    exit?: TransitionSection,
    transition?: TransitionDuration
}