import Button from '../../common/Button'
import { type ButtonProps } from '../../../types'
import { type CrudButtonProps } from '../../../types/components'

//componente que recibe un array de botones para mostrar en la parte de actions de la tabla
export default function ActionSection({
    as: Tag=Button,
    actions=[],
    className=''
}:{
    as: React.ElementType
    actions :  ButtonProps[] | CrudButtonProps[],
    className?: string

}) {
  return (
    <div className={`flex flex-row w-1/2 justify-center gap-2 ${className}`}>
      {actions.map((action, index) => (
        <Tag key={index} {...action} />
      ))}
    </div>
  )
}
