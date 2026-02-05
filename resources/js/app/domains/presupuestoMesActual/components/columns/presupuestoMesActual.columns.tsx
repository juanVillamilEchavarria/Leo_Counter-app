import { Link } from "@inertiajs/react";
import ActionSection from "@/app/shared/components/table/actions/ActionSection";
import { type PresupuestoMesActualTableData, PresupuestoMesActualActions, PresupuestoMesActualRoutes } from "../../types/presupuestoMesActual.types";
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions";
import { moneyFormat } from "@/app/shared/helpers";
import CrudButton from "@/app/shared/components/common/CrudButton";


const buildPresupuestoMesActualActions = (
  row: PresupuestoMesActualTableData,
  onDelete: (row: PresupuestoMesActualTableData, modal: string) => void
) => [
  {
    as: Link,
    href: PresupuestoMesActualRoutes.edit(row.id),
    Crudvariant: 'Edit',
  },
  {
    onClick: () => onDelete(row, 'delete'),
    Crudvariant: 'Delete',
  },
  {
    onClick: () => onDelete(row, 'duplicar'),
    Crudvariant: 'Create',
    icon: 'fa-solid fa-clone fa-sm',
    className: 'p-2! m-0!',
    withSpan: false
  }
]

export const PresupuestoMesActualColumns = (({
    onDelete
}: {
    onDelete: (presupuesto: PresupuestoMesActualTableData, modal : string) => void
}) => {
    return [
        { key: "id", label: "ID" },
        { key: "categoria", label: "Categoría", className: 'w-60' },
         {key: "user", label: "Creado por"},
        { key: "monto", label: "Monto", render: (row: PresupuestoMesActualTableData) => moneyFormat(Number(row.monto)) },
        {key: "descripcion", label: "Descripcion" },
        {
            key: 'actions',
            label: '',
            className: 'w-40',
            render: (row: PresupuestoMesActualTableData) => (
                <ActionSection actions={buildPresupuestoMesActualActions(row,onDelete)} as={CrudButton} />
            )
        }
    ]
})
