const TransitionBaseStyles = `
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
export const ButtonVariants = {
  primary:      'bg-azul hover:bg-azulOscuro text-white',
  secondary:        'bg-gray-500 hover:bg-gray-700 text-white',
  danger:       'bg-rojo hover:bg-rojoOscuro text-white',
'transition-blue': `
                    bg-linear-to-r 
                    from-azul-oscuro
                    via-azul-claro
                    to-azul-oscuro
                    ${TransitionBaseStyles}
                `,
 'transition-blue-green': `
                    bg-linear-to-r 
                    from-azul-claro
                    via-verde
                    to-azul-claro
                    ${TransitionBaseStyles}
                `,               

} as const

export type ButtonTypes = 'button' | 'submit' | 'reset'
export type ButtonVariant = keyof typeof ButtonVariants
export type ButtonProps = {
     type? : ButtonTypes
    className? : string
    variant? : ButtonVariant
    disabled? : boolean
    children?: React.ReactNode 
}
