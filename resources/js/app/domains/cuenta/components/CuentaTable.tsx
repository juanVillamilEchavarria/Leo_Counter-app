import DeleteModal from "@/app/shared/components/modal/DeleteModal";
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useSimplePagination } from "@/app/shared/hooks";
import { useState, useMemo } from "react";
import { CuentaColumns } from "./columns/cuenta.columns";
import useCuenta from "../hooks/useCuenta";
import { type Cuenta } from "../types/cuenta.types";
export default function CuentaTable({

  pageSize = 10, //cantidad de registros a mostrar
  data
}:{
  pageSize?: number,
  data: Cuenta[]
}) {
  const [cuentaSelected, setCuentaSelected] = useState<Cuenta|null>(null) // el estado para manejar el id de la cuenta que se va a eliminar

  const columns = useMemo(()=>{
    return CuentaColumns({ // le pasamos la cuenta que se va a eliminar
      onDelete: (cuenta : Cuenta)=>{ // cuando le de click al boton de eliminar, se abre el modal y se le asigna la cuenta al state
        setCuentaSelected(cuenta)
      }
    })
  }, []) 
    const {form, handleSubmit} = useCuenta({ // llamamos al hook para hacer la peticion al servidor
    method: 'delete',
    id: cuentaSelected?.id,
  })
  const handleDelete = (e: React.FormEvent<HTMLFormElement>) => {
    if (!cuentaSelected) return  // si no hay cuenta seleccionada, no hacemos nada
    handleSubmit(e)
    setCuentaSelected(null)
  }
  
  const pagination = useSimplePagination(data.length, 10)
  const start = pagination.page * pageSize //es el inicio de donde se va a tomar el registro, ejemplo, si la pagina es 0 y el pageSize es 10, entonces el start es 0
  const end = start + pageSize // es el final de donde se va a tomar el registro, por ejemplo si el start es 0 y el pageSize es 10, entonces el end es 10
  const paginatedData = data.slice(start, end) // es el array que se va a mostrar en la tabla
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
      open={cuentaSelected !== null}
      onClose={() => setCuentaSelected(null)}
       onSubmit={handleDelete}
      spanTitle={'Archivar'}
      title={' Cuenta'}
      paragraph={`¿Esta seguro de eliminar la Cuenta: ${cuentaSelected?.nombre} ?`}
      >
        <small>las cuentas archivadas estaran en la configuracion del sistema</small>
      </DeleteModal>
     </>
  )
}
