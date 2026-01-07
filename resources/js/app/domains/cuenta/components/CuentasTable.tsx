import EditAndDeleteActions from "@/app/shared/components/table/actions/EditAndDeleteActions"
import ToggleState from "@/app/shared/components/table/ToggleState";
import { type Cuenta } from "../types/cuenta.types";
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useSimplePagination } from "@/app/shared/hooks/table/simple/useSimpleTablePagination";
import { useState, useMemo } from "react";
export default function CuentasTable({
  pageSize = 10,
}) {
  const [active, setActive] = useState(false)
  const data: Cuenta[] = [
    {
      id: 1,
      nombre: "Cuenta 1",
      saldoInicial: 1000,
      saldoActual: 2000,
      tipo: "Ahorro",
      notas: "Notas",
      active: true
    },
    {
      id: 2,
      nombre: "Cuenta 2",
      saldoInicial: 1000,
      saldoActual: 2000,
      tipo: "Ahorro",
      notas: "Notas",
      active: false
    }
  ]
  const columns = useMemo(()=>{
    return [
    { key: "id", label: "ID" },
    { key: "nombre", label: "Nombre" },
    { key: "saldoInicial", label: "Saldo Inicial" },
    { key: "saldoActual", label: "Saldo Actual" },
    { key: "tipo", label: "Tipo de cuenta" },
    { key: "notas", label: "Notas" },
    {
      key: 'active',
      label: 'Active',
      render: (row : Cuenta)=>(
        <ToggleState 
        active={row.active}
        setActive={setActive}
        />
      )
    },
    {
      key: 'actions',
      label: '',
      render: ()=>(
        <EditAndDeleteActions />
      )
    }
  ]
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
