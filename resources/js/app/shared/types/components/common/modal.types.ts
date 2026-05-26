export const ModalSizes={
        sm : 'w-1/6 h-1/6',
        md : 'w-1/4 h-1/4',
        lg : 'w-1/3 h-1/3',
        xl : 'w-1/2 h-1/2',
        '2xl' : 'w-2/3 h-2/3'
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