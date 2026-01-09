import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import ToggleState from "@/app/shared/components/table/actions/ToggleState";
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useSimplePagination } from "@/app/shared/hooks";
import { useState, useMemo } from "react";
import { CuentaColumns } from "./columns/cuenta.columns";
import { type Cuenta } from "../types/cuenta.types";
export default function CuentaTable({
  pageSize = 10, //cantidad de registros a mostrar
  data
}:{
  pageSize?: number,
  data: Cuenta[]
}) {
  const columns = useMemo(()=>{
    return CuentaColumns
  }, []) 
  const pagination = useSimplePagination(data.length, 10)
  const start = pagination.page * pageSize //es el inicio de donde se va a tomar el registro, ejemplo, si la pagina es 0 y el pageSize es 10, entonces el start es 0
  const end = start + pageSize // es el final de donde se va a tomar el registro, por ejemplo si el start es 0 y el pageSize es 10, entonces el end es 10
  const paginatedData = data.slice(start, end) // es el array que se va a mostrar en la tabla
  return (
    <SimpleTable
    data={paginatedData}
    columns={columns}
    pagination={true}
    pageSize={pageSize}
    controller={pagination}

     />
  )
}
