export const CardVariants=
{
    primary: ` bg-white/20 backdrop-blur-4xl shadow-[0_20px_50px_rgba(0,0,0,0.6)] border border-gray-200/50 `, 
} as const
export type CardProps = {
    children : React.ReactNode
    variant? : keyof typeof CardVariants
    className? : string
    scrollable? : boolean
}