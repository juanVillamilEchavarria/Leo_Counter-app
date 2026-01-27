import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import usePropietario from "../hooks/usePropietario"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useSimpleTable } from "@/app/shared/hooks"
import { PropietarioColumns } from "./columns/propietarios.columns"
import { type Propietario } from "../types/propietario.types"

export default function PropietarioTable({
  pageSize = 10,
  data
}: {
  pageSize?: number,
  data: Propietario[]
}) {
  const config = useSimpleTable({
    data,
    pageSize,
    tableColumns: PropietarioColumns,
    formModelHook: usePropietario
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
        title={' Propietario'}
        paragraph={`¿Esta seguro de eliminar el propietario: ${itemSelected?.nombre} ${itemSelected?.apellido} ?`}
      >
        <small>los propietarios eliminados no son recuperables, si este propietario esta asignado a una cuenta, considera inmediatamente luego de esta accion asignarle un nuevo propietario</small>
      </DeleteModal>
    </>
  )
}
