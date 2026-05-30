/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Button from "./Button"
import { type CrudButtonProps } from "../../types/components"
export default function CrudButton({
    as='button',
    Crudvariant = 'Create',
    icon='',
    type = 'button',
    disabled = false,
    className = '',
    href = '#',
    onClick = undefined,
    withSpan=true
}:CrudButtonProps) {
    const CreateStyles= 'rounded-lg px-4 py-2 text-sm shadow-2xl mb-2 '
    const EditAndDeleteStyles='rounded-xl px-2 py-2 text-center text-xs shadow-2xl'

  if(Crudvariant==='Create'){return(
    <Button
        as={as}
        href={href} 
        onClick={onClick}
        type={type}
        disabled={disabled}
        variant="successSecondary"
        className={`${CreateStyles} ${className}`}
    >
        <i className={icon}></i>
        {withSpan &&(
         <span> Nuevo</span>
        )}
        
    </Button>
  )}
  if(Crudvariant==='Edit')return(
    <Button
        as={as}
        href={href} 
        onClick={onClick}
        type={type}
        disabled={disabled}
        variant="secondary"
        className={`${EditAndDeleteStyles} ${className}`}
    >
        <i className={` ${icon ? icon : 'fa-solid fa-pen'}`}></i>

    </Button>
     
  )
  if(Crudvariant==='Delete')return(
    <Button
    as={as}
    href={href} 
    onClick={onClick}
    type={type}
    disabled={disabled}
    variant="dangerSecondary" 
    className={`${EditAndDeleteStyles}${className}`}
    >
        <i className={` ${icon ? icon : 'fa-solid fa-trash '}`}></i>
    </Button>
     
  )
  return null
}
