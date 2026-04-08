// -----------
// STYLES DEL BOTON
// -----------

const ButtonBaseStyles= `w-full p-2 rounded-2xl cursor-pointer`
const ButtonTransitionBaseStyles = `
                    bg-[length:200%_100%]
                    bg-left
                    text-[shadow:0_1px_2px_rgba(0,0,0,0.2)]
                    shadow-lg
                    transition-all
                    duration-700
                    ease-in-out
                    hover:bg-right
                    hover:shadow-[0_3px_10px_rgba(255,255,255,0.4)]
                    border-0
                    rounded-xl
                    px-6
                    py-3
                    font-semibold
                    cursor-pointer
                    hover:text-foreground!
                    `
const TransitionCommonStyles= 'transition-all ease-in-out duration-400 '
const ButtonBorderedBaseStyles = 'bg-background border hover:text-foreground! '
export const ButtonVariants = {
    gray: `
                      bg-gray-300 
                      hover:bg-gray-400 
                      text-black
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
  clean: '',
  primary:      `
                      bg-azul 
                      hover:bg-azul-oscuro 
                      dark:bg-azul-claro
                      dark:hover:bg-cyan-100
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
  success:       `
                      bg-green-800 
                      hover:bg-green-700 
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
  successSecondary: `
                      ${ButtonBorderedBaseStyles}
                      border-green-600 
                      hover:bg-green-800 
                      darK:text-green-400 
                      text-green-600
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
secondary:       `
                      ${ButtonBorderedBaseStyles} 
                      ${ButtonBaseStyles}
                      border-azul-claro 

                      dark:hover:bg-cyan-900
                      hover:bg-azul-claro
                      hover:text-white! 
                      text-azul-claro
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                          `,
danger:       `
                      bg-rojo 
                      hover:bg-rojo-oscuro 
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
  dangerSecondary: `  
                      ${ButtonBorderedBaseStyles}
                      ${ButtonBaseStyles}
                      border-rojo 
                      hover:bg-rojo
                      text-rojo
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
  dark:`
                      bg-slate-900
                      hover:bg-slate-800 
                      text-primary-foreground 
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
  primaryPagination: `
                      bg-background/10 
                      border-t-2 
                      border-transparent  
                      hover:border-gray-400 
                      text-gray-400
                      hover:text-foreground
                      ${TransitionCommonStyles}
                      ${ButtonBaseStyles}
                      `,
'transition-blue': `
                      bg-linear-to-r 
                      from-azul-oscuro
                      via-azul-claro
                      to-azul-oscuro
                      ${ButtonTransitionBaseStyles}
                      ${ButtonBaseStyles}
                `,
 'transition-blue-green': `
                      bg-linear-to-r 
                      from-azul-claro
                      via-verde
                      to-azul-claro
                      ${ButtonTransitionBaseStyles}
                      ${ButtonBaseStyles}
                `,               

} as const
// -----------

export type ButtonTypes = 'button' | 'submit' | 'reset'
export type ButtonVariant = keyof typeof ButtonVariants
export type ButtonProps = {
    as? : React.ElementType
    href? : string
    onClick? : () => void | undefined | Promise<void>
     type? : ButtonTypes
    className? : string
    variant? : ButtonVariant
    disabled? : boolean
    children?: React.ReactNode 
}
