/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { Link } from "@inertiajs/react";
import ActionSection from "@/app/shared/components/table/actions/ActionSection";
import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions";
import { type PresupuestoMesActualTableData, PresupuestoMesActualActions, PresupuestoMesActualRoutes } from "../../types/presupuestoMesActual.types";
import { moneyFormat } from "@/app/shared/helpers";
import CrudButton from "@/app/shared/components/common/CrudButton";


const buildPresupuestoMesActualActions = (
  row: PresupuestoMesActualTableData,
  onSelect: (row: PresupuestoMesActualTableData, modal: string) => void
) => [
  {
    as: Link,
    href: PresupuestoMesActualRoutes.edit(row.id),
    Crudvariant: 'Edit',
  },
  {
    onClick: () => onSelect(row, 'delete'),
    Crudvariant: 'Delete',
  },
  {
    onClick: () => onSelect(row, 'duplicate'),
    Crudvariant: 'Create',
    icon: 'fa-solid fa-clone fa-sm',
    className: 'p-2! m-0!',
    withSpan: false
  }
]

export const PresupuestoMesActualColumns = (({
    onSelect
}: {
    onSelect: (presupuesto: PresupuestoMesActualTableData, modal : string) => void
}) => {
    return [
        { key: "id", label: "ID" },
        { key: "categoria", label: "Categoría", className: 'w-60' },
         {key: "user", label: "Creado por"},
        { key: "monto", label: "Monto", render: (row: PresupuestoMesActualTableData) => moneyFormat(Number(row.monto)) },
        {key: "descripcion", label: "Descripcion" },
        {
          key: 'isDuplicate',
          label: 'Duplicado para proximo mes',
          className: 'text-center',
          render: (row: PresupuestoMesActualTableData) => (
            <i className={`fa-regular ${row.isDuplicate ? 'fa-circle-check text-green-400' : 'fa-circle-xmark text-red-400'} text-2xl`}></i>
           
          )
        },
        {
            key: 'actions',
            label: '',
            className: 'w-40',
            render: (row: PresupuestoMesActualTableData) => { return !row.isDuplicate ?(
                <ActionSection actions={buildPresupuestoMesActualActions(row,onSelect)} as={CrudButton} />
            ):(
              <div className="w-1/2 mx-auto">
                 <EditAndDeleteActions
              editHref={PresupuestoMesActualRoutes.edit(row.id)}
              deleteOnClick={()=>onSelect(row,'delete')}
                />
              </div>
             

            )}
        }
    ]
})
