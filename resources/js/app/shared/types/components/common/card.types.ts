const baseStyle = 'backdrop-blur-4xl shadow-[0_20px_50px_rgba(0,0,0,0.6)]'
export const CardVariants=
{
    primary: ` bg-white/20 ${baseStyle} border border-gray-200/50 `, 
    secondary: `bg-wite-200/20 ${baseStyle} border-l-10 border-gray-600/20 `,
    success: `bg-green-200/20 ${baseStyle} border border-green-200/50 `,
    danger: `bg-red-200/20 ${baseStyle} border border-red-200/50 `,
    successSecondary: 'bg-green-100/20 ${baseStyle} border-l-10 border-green-600/20',
    dangerSecondary: 'bg-red-100/20 ${baseStyle} border-l-10 border-red-600/20'
} as const
export type CardProps = {
    children : React.ReactNode
    variant? : keyof typeof CardVariants
    className? : string
    scrollable? : boolean
}