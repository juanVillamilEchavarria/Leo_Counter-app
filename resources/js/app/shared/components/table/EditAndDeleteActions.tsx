import CrudButton from "../common/CrudButton"
import { Link } from "@inertiajs/react"
import { type EditAndDeleteActionsProps } from "../../types/components"
import ActionSection from "./ActionSection"
export default function EditAndDeleteActions({
    editHref='#',
    deleteOnClick=undefined
}:EditAndDeleteActionsProps) {
  const actions=[
    {
      as:Link,
      href:editHref,
      Crudvariant:'Edit'
    },
    {
      onClick:deleteOnClick,
      Crudvariant:'Delete'
    }
  ]
  return (
      <ActionSection actions={actions} as={CrudButton}></ActionSection>
  )
}
