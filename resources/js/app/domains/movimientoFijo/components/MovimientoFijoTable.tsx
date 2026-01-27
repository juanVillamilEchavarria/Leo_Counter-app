import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import useMovimientoFijo from "../hooks/useMovimientoFijo"
import { useSimpleTable } from "@/app/shared/hooks"
import { MovimientoFijoColumns } from "./columns/movimientoFijo.columns"
import { type MovimientoFijoTableData } from "../types/movimientoFijo.types"

export default function MovimientoFijoTable({
  data
}: {
  data: MovimientoFijoTableData[]
}) {
  const config = useSimpleTable({
    data,
    pageSize: data.length,
    tableColumns: MovimientoFijoColumns,
    formModelHook: useMovimientoFijo
  })

  const {
    data: paginatedData,
    columns,
    handleDelete,
    itemSelected,
    setItemSelected
  } = config

  return (
    <>
      <SimpleTable
        data={paginatedData}
        columns={columns}
        pagination={false}
      />
      <DeleteModal
        open={itemSelected !== null}
        spanTitle="Eliminar"
        title='Movimiento Fijo'
        onClose={() => setItemSelected(null)}
        paragraph={`¿Esta seguro de eliminar el Movimiento Fijo con ID: ${itemSelected?.id} ?`}
        onSubmit={handleDelete}
      >
        <small>Los Movimientos fijos eliminados no se pueden recuperar, solo los movimientos fijos sin movimientos asociados pueden ser eliminados, si no lo usaras mas, mejor marcalo como inactivo</small>
      </DeleteModal>
    </>
  )
}
