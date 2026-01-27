import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import useCategoria from "../hooks/useCategoria"
import { useSimpleTable } from "@/app/shared/hooks"
import { CategoriaColumns } from "./columns/categoria.columns"
import { type Categoria } from "../types/categoria.types"

export default function CategoriaTable({
  data,
  pageSize = 10
}: {
  data: Categoria[],
  pageSize?: number
}) {
  const config = useSimpleTable({
    data,
    pageSize,
    tableColumns: CategoriaColumns,
    formModelHook: useCategoria
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
        title={' Categoria'}
        paragraph={`¿Esta seguro de eliminar la Categoria: ${itemSelected?.nombre} ?`}
      >
        <small>las categorias no pueden ser recuperadas, si esta categoria esta asociada a algun tipo de movimiento fijo, considera inmediatamente luego de esta accion asignar una categoria a dicho movimiento</small>
      </DeleteModal>
    </>
  )
}
