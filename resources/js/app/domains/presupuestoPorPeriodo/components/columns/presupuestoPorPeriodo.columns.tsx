import { type PresupuestoPorPeriodoTableData, PresupuestoPorPeriodoRoutes } from "../../types/presupuestoPorPeriodo.types";
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions";
import { dateFormat } from "@/app/shared/helpers";
import { moneyFormat } from "@/app/shared/helpers";
export const PresupuestoPorPeriodoColumns = (({
    onDelete
}: {
    onDelete: (presupuesto: PresupuestoPorPeriodoTableData) => void
}) => {
    return [
        { key: "id", label: "ID" },
        { key: "categoria", label: "Categoría" },
        {key: "user", label: "Creado por"},
        { key: "tipo_presupuesto", label: "Tipo"},
        { key: "monto", label: "Monto", render: (row: PresupuestoPorPeriodoTableData) => moneyFormat(Number(row.monto)) },
        { key: "fecha_inicio", label: "Fecha Inicio", render: (row: PresupuestoPorPeriodoTableData) => dateFormat(row.fecha_inicio) },
        { key: "fecha_final", label: "Fecha Final", render: (row: PresupuestoPorPeriodoTableData) => dateFormat(row.fecha_final) },
        { key: "descripcion", label: "Descripción", className: 'w-80' },
        {
            key: 'actions',
            label: '',
            className: 'w-20',
            render: (row: PresupuestoPorPeriodoTableData) => (
                <EditAndDeleteActions 
                    editHref={PresupuestoPorPeriodoRoutes.edit(row.id)}
                    deleteOnClick={() => onDelete(row)}
                />
            )
        }
    ]
})
