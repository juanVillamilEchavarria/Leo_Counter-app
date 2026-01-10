export const ModalSizes={
        sm : 'w-1/6 h-1/6',
        md : 'w-1/4 h-1/4',
        lg : 'w-1/3 h-1/3',
        xl : 'w-1/2 h-1/2',
        '2xl' : 'w-2/3 h-2/3'
    }
export const ModalVariants={
        primary : 'bg-white backdrop-blur-4xl',
        secondary: 'bg-linear-to-br from-azul-oscuro/90  to-azul-negro/90 backdrop-blur-4xl text-white'
}    
export type ModalProps={
    children : React.ReactNode,
    title : string | React.ReactNode,
    open : boolean,
    variant: keyof typeof ModalVariants
    onClose : () => void 
    size? : keyof typeof ModalSizes
}

export type DeleteModalProps= Omit<ModalProps, 'variant'| 'size'>&{
    spanTitle : string,
    paragraph : string,
    onSubmit : (e: React.FormEvent<HTMLFormElement>) => void
}