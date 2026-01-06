import EditAndDeleteActions from "@/app/shared/components/table/EditAndDeleteActions"
import ToggleState from "@/app/shared/components/table/ToggleState";
import { type Cuenta } from "../types/cuenta.types";
import SimpleTable from "@/app/shared/components/table/SimpleTable";
import { useState, useMemo } from "react";
export default function CuentasTable() {
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
  return (
    <SimpleTable
    data={data}
    columns={columns}

     />
  )
}
