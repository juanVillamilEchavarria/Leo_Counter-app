/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type ButtonTypes } from "./button.types"
import {type ButtonProps } from "./button.types"
export type CrudButtonVariants = 'Create'| 'Edit'| 'Delete'
export type CrudButtonProps=Omit<ButtonProps, 'variant'|'children'>&{
    Crudvariant?: CrudButtonVariants
    icon?: string,
    className?: string
    withSpan?: boolean

}