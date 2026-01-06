import CrudButton from "../common/CrudButton"
import { Link } from "@inertiajs/react"
import { type EditAndDeleteActionsProps } from "../../types/components"
export default function EditAndDeleteActions({
    editHref='#',
    deleteOnClick=undefined
}:EditAndDeleteActionsProps) {
  return (
     <div className="flex flex-row w-1/2 justify-center gap-2">
            <CrudButton
            as={Link}
            href={editHref}
            Crudvariant="Edit"
            />
            <CrudButton
            onClick={deleteOnClick}
            Crudvariant="Delete"
            />
    </div>
  )
}
