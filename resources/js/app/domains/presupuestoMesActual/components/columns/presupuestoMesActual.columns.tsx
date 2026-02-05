import { type PresupuestoMesActualTableData, PresupuestoMesActualActions, PresupuestoMesActualRoutes } from "../../types/presupuestoMesActual.types";
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions";
import { moneyFormat } from "@/app/shared/helpers";

export const PresupuestoMesActualColumns = (({
    onDelete
}: {
    onDelete: (presupuesto: PresupuestoMesActualTableData) => void
}) => {
    return [
        { key: "id", label: "ID" },
        { key: "categoria", label: "Categoría", className: 'w-60' },
         {key: "user", label: "Creado por"},
        { key: "tipo_presupuesto", label: "Tipo", className: 'w-40' },
        { key: "monto", label: "Monto", render: (row: PresupuestoMesActualTableData) => `${moneyFormat(row.monto)}` },
        {key: "descripcion", label: "Descripcion" },
        {
            key: 'actions',
            label: '',
            className: 'w-20',
            render: (row: PresupuestoMesActualTableData) => (
                <EditAndDeleteActions 
                    editHref={PresupuestoMesActualRoutes.edit(row.id)}
                    deleteOnClick={() => onDelete(row)}
                />
            )
        }
    ]
})
