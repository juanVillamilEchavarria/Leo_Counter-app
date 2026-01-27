import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import usePresupuesto from "../hooks/usePresupuesto"
import { useSimpleTable } from "@/app/shared/hooks"
import { PresupuestoMesActualColumns } from "./columns/presupuestoMesActual.columns"
import { type PresupuestoMesActualTableData } from "../types/presupuestoMesActual.types"

export default function PresupuestoMesActualTable({
  data,
  pageSize = 10
}: {
  data: PresupuestoMesActualTableData[],
  pageSize?: number
}) {
  const config = useSimpleTable({
    data,
    pageSize,
    tableColumns: PresupuestoMesActualColumns,
    formModelHook: usePresupuesto
  })

  const {
    data: paginatedData,
    columns,
    pagination,
    handleDelete,
    itemSelected,
    setItemSelected
  } = config

  return (
    <>
      <SimpleTable
        data={paginatedData}
        columns={columns}
        pagination={true}
        controller={pagination}
      />
      <DeleteModal
        open={itemSelected !== null}
        onClose={() => setItemSelected(null)}
        onSubmit={handleDelete}
        spanTitle={'Eliminar'}
        title={' Presupuesto'}
        paragraph={`¿Esta seguro de eliminar el Presupuesto de: ${itemSelected?.categoria} (${itemSelected?.descripcion || 'Sin descripción'}) ?`}
      >
        <small>Los presupuestos eliminados estaran en la configuración del sistema</small>
      </DeleteModal>
    </>
  )
}
