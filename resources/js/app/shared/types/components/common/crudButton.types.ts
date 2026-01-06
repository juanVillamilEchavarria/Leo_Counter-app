import { type ButtonTypes } from "./button.types"
export type CrudButtonVariants = 'Create'| 'Edit'| 'Delete'
export type CrudButtonProps={
    as?: React.ElementType
    Crudvariant?: CrudButtonVariants
    type?: ButtonTypes,
    disabled?: boolean
    icon?: string,
    className?: string
    href?: string
    onClick?: () => void | undefined
}