import { type ButtonTypes } from "./button.types"
import {type ButtonProps } from "./button.types"
export type CrudButtonVariants = 'Create'| 'Edit'| 'Delete'
export type CrudButtonProps=Omit<ButtonProps, 'variant'|'children'>&{
    Crudvariant?: CrudButtonVariants
    icon?: string,
    className?: string
    withSpan?: boolean

}