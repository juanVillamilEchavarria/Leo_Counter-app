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
