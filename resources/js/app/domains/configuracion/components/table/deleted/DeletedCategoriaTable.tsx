import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useMemo } from "react";
import { deletedCategoriaColumns } from "../../columns/deleted/categoria/deleted.categoria.columns";
import { type CategoriaTableData } from "@/app/domains/categoria";
import { type DeletedDomainModalTypes } from "../../columns/deleted/utils/configuracion.deleted.columns.utils";

export default function DeletedCategoriaTable({
    data,
    onSelect
}:{
    data: CategoriaTableData[]
    onSelect: (item: CategoriaTableData, modalType: DeletedDomainModalTypes) => void
}) {
    const columns = useMemo(()=>{
        return deletedCategoriaColumns({
          onSelect: (item: CategoriaTableData, modalType: DeletedDomainModalTypes) => {
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
