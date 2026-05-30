/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
export const ModalSizes={
        sm : 'w-11/12 sm:w-1/2 lg:w-1/6 min-h-40',
        md : 'w-11/12 sm:w-2/3 lg:w-1/4 min-h-64',
        lg : 'w-11/12 sm:w-2/3 lg:w-1/3 min-h-80',
        xl : 'w-11/12 sm:w-3/4 lg:w-1/2 min-h-[50vh]',
        '2xl' : 'w-11/12 sm:w-5/6 lg:w-2/3 min-h-[66vh]'
    }
export const ModalVariants={
    primary : 'bg-background backdrop-blur-sm text-foreground',
    secondary: 'bg-background border border-border shadow-sm backdrop-blur-sm text-foreground'
}    
export type ModalProps={
    children ?: React.ReactNode,
    title : string | React.ReactNode,
    open : boolean,
    variant?: keyof typeof ModalVariants
    onClose : () => void 
    size? : keyof typeof ModalSizes
    className? : string
}

export type DeleteModalProps= Omit<ModalProps, 'variant'>&{
    spanTitle? : string,
    paragraph : string| React.ReactNode
    onSubmit : (e: React.FormEvent<HTMLFormElement>) => void
}
