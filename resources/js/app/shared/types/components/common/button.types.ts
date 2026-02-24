// -----------
// STYLES DEL BOTON
// -----------
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
                    text-white
                    cursor-pointer
                    `
const TransitionCommonStyles= 'transition-all ease-in-out duration-400 '
const ButtonBorderedBaseStyles = 'bg-white border hover:text-white '
export const ButtonVariants = {
    gray: `
                      bg-gray-300 
                      hover:bg-gray-400 
                      text-black 
                      ${TransitionCommonStyles}
                      `,
  clean: '',
  primary:      `
                      bg-azul 
                      hover:bg-azul-oscuro 
                      text-white 
                      ${TransitionCommonStyles}
                      `,
  success:       `
                      bg-green-800 
                      text-white 
                      hover:bg-green-700 
                      ${TransitionCommonStyles}
                      `,
  successSecondary: `
                      ${ButtonBorderedBaseStyles}
                      border-green-800 
                      hover:bg-green-800 
                      text-green-800 
                      ${TransitionCommonStyles}
                      `,
secondary:       `
                      ${ButtonBorderedBaseStyles} 
                      border-azul 
                      hover:bg-azul-oscuro 
                      text-azul
                      ${TransitionCommonStyles}
                          `,
danger:       `
                      bg-rojo 
                      hover:bg-rojo-oscuro 
                      text-white 
                      ${TransitionCommonStyles}
                      `,
  dangerSecondary: `  
                      ${ButtonBorderedBaseStyles}
                      border-rojo 
                      hover:bg-rojo
                      text-rojo
                      ${TransitionCommonStyles}
                      `,
  dark:`
                      bg-slate-900
                      hover:bg-slate-800 
                      text-white 
                      ${TransitionCommonStyles}
                      `,
  primaryPagination: `
                      bg-white/10 
                      border-t-2 
                      border-transparent  
                      hover:border-gray-400 
                      text-gray-400
                      hover:text-black
                      ${TransitionCommonStyles}
                      `,
'transition-blue': `
                      bg-linear-to-r 
                      from-azul-oscuro
                      via-azul-claro
                      to-azul-oscuro
                      ${ButtonTransitionBaseStyles}
                `,
 'transition-blue-green': `
                      bg-linear-to-r 
                      from-azul-claro
                      via-verde
                      to-azul-claro
                      ${ButtonTransitionBaseStyles}
                `,               

} as const
// -----------

export type ButtonTypes = 'button' | 'submit' | 'reset'
export type ButtonVariant = keyof typeof ButtonVariants
export type ButtonProps = {
    as? : React.ElementType
    href? : string
    onClick? : () => void | undefined
     type? : ButtonTypes
    className? : string
    variant? : ButtonVariant
    disabled? : boolean
    children?: React.ReactNode 
}
