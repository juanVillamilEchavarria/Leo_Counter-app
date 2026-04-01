import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useMemo } from "react";
import { deletedCuentaColumns } from "../../columns/deleted/cuenta/deleted.cuenta.columns";
import { type Cuenta } from "@/app/domains/cuenta";
import { type DeletedDomainModalTypes } from "../../columns/deleted/utils/configuracion.deleted.columns.utils";

export default function DeletedCuentaTable({
    data,
    onSelect
}:{
    data: Cuenta[]
    onSelect: (item: Cuenta, modalType: DeletedDomainModalTypes) => void
}) {
    const columns = useMemo(()=>{
        return deletedCuentaColumns({
          onSelect: (item: Cuenta, modalType: DeletedDomainModalTypes) => {
            onSelect(item, modalType)
          }
        })
        
    },[onSelect])
  return (
    <SimpleTable
      data={data}
      columns={columns}
      pagination={true}
      pageSize={10}
    />
  )
}
