/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import CrudButton from "../../common/CrudButton"
import { Link } from "@inertiajs/react"
import { type EditAndDeleteActionsProps } from "../../../types/components"
import ActionSection from "./ActionSection"
export default function EditAndDeleteActions({
    editHref='#',
    deleteOnClick=undefined,
    editIcon,
    deleteIcon
}:EditAndDeleteActionsProps) {
  const actions=[
    {
      as:Link,
      href:editHref,
      Crudvariant:'Edit',
      icon : editIcon ?? ''
    },
    {
      onClick:deleteOnClick,
      Crudvariant:'Delete',
      icon : deleteIcon ?? ''

    }
  ]
  return (
      <ActionSection actions={actions} as={CrudButton}></ActionSection>
  )
}
