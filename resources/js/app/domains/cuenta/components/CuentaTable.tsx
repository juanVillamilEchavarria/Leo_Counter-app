import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useSimpleTable } from "@/app/shared/hooks";
import { CuentaColumns } from "./columns/cuenta.columns";
import { type Cuenta } from "../types/cuenta.types";
import { useMemo } from "react";

export default function CuentaTable({
  pageSize = 10,
  data,
  onSelect
}: {
  pageSize?: number,
  data: Cuenta[],
  onSelect: (item: Cuenta, modalType: string) => void
}) {
  const {data: paginatedData, pagination}  = useSimpleTable({
    data,
    pageSize,
   })
  const columns = useMemo(()=>{
    return CuentaColumns({
      onSelect: (item: Cuenta) => {
        onSelect(item, 'delete')
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={paginatedData}
      columns={columns}
      pagination={true}
      controller={pagination}
      pageSize={pageSize}
    />
  )
}
