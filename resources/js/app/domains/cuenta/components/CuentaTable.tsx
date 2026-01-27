import DeleteModal from "@/app/shared/components/modal/DeleteModal";
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useSimpleTable } from "@/app/shared/hooks";
import { CuentaColumns } from "./columns/cuenta.columns";
import useCuenta from "../hooks/useCuenta";
import { type Cuenta } from "../types/cuenta.types";

export default function CuentaTable({
  pageSize = 10,
  data
}: {
  pageSize?: number,
  data: Cuenta[]
}) {
  const config = useSimpleTable({
    data,
    pageSize,
    tableColumns: CuentaColumns,
    formModelHook: useCuenta
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
        pageSize={pageSize}
        controller={pagination}
      />
      <DeleteModal
        open={itemSelected !== null}
        onClose={() => setItemSelected(null)}
        onSubmit={handleDelete}
        spanTitle={'Archivar'}
        title={' Cuenta'}
        paragraph={`¿Esta seguro de eliminar la Cuenta: ${itemSelected?.nombre} ?`}
      >
        <small>las cuentas archivadas estaran en la configuracion del sistema</small>
      </DeleteModal>
    </>
  )
}
