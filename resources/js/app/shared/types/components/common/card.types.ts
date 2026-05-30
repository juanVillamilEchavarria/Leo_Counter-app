/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
const baseStyle = 'backdrop-blur-4xl shadow-[0_20px_50px_rgba(0,0,0,0.6)]'
export const CardVariants=
{
    primary: ` bg-background/20 ${baseStyle} border border-border `, 
    secondary: `bg-wite-200/20 ${baseStyle} border-l-10 border-muted-foreground/20 `,
    success: `bg-green-200/20 ${baseStyle} border border-green-200/50 `,
    danger: `bg-red-200/20 ${baseStyle} border border-red-200/50 `,
    successSecondary: `bg-green-100/10 ${baseStyle} border-l-10 border-green-600/20 dark:bg-green-700/10`,
    dangerSecondary: `bg-red-100/20 ${baseStyle} border-l-10 border-red-600/20 dark:bg-red-700/10`,
} as const
export type CardProps = {
    children : React.ReactNode
    variant? : keyof typeof CardVariants
    className? : string
    scrollable? : boolean
}