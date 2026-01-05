export const CardVariants=
{
    primary: ` bg-white/20 backdrop-blur-4xl` 
} as const
export type CardProps = {
    children : React.ReactNode
    variant? : keyof typeof CardVariants
    className? : string
    scrollable? : boolean
}