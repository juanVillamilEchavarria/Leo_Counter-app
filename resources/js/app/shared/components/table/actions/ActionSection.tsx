/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Button from '../../common/Button'
import CrudButton from '../../common/CrudButton'
import { type ButtonProps } from '../../../types'
import { type CrudButtonProps } from '../../../types/components'

interface ActionSectionProps {
  as: typeof Button | typeof CrudButton
  actions :  ButtonProps[] | CrudButtonProps[],
  className?: string
}
/**
 * Componente de las acciones de la tabla
 * @param {string} className - Clases adicionales para el contenedor
 * @param {ButtonProps[] | CrudButtonProps[]} actions - array de la configuracion de las Acciones a mostrar 
 * @param {typeof Button | typeof CrudButton} as - Componente a usar
 * @returns 
 */
export default function ActionSection({
    as: Tag=Button,
    actions=[],
    className=''
}:ActionSectionProps) {
  return (
    <div className={`flex flex-row justify-center items-center gap-2 ${className}`}>
      {actions.map((action, index) => (
        <Tag key={index} {...action} />
      ))}
    </div>
  )
}
