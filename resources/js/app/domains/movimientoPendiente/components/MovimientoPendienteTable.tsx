import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import useMovimientoPendiente from "../hooks/useMovimientoPendiente"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import MarkAsDoneModal from "./MarkAsDoneModal"
import Modal from "@/app/shared/components/modal/Modal"
import { useSimpleTable } from "@/app/shared/hooks"
import { useDropzone, type FileRejection } from "react-dropzone"
import { useCallback , useState} from "react"
import useMovimientoPendienteActions from "../hooks/useMovimientoPendienteActions"
import { MovimientoPendienteColumns } from "./columns/movimientoPendiente.columns"
import { type MovimientoPendienteTableData, type MarkAsDonePayload } from "../types/movimientoPendiente.types"
import { type FileWithPreview } from "@/app/shared/types"
export default function MovimientoPendienteTable({
  data
}: {
  data: MovimientoPendienteTableData[]
}) {
  const config = useSimpleTable({
    data,
    pageSize: data.length,
    tableColumns: MovimientoPendienteColumns,
    formModelHook: useMovimientoPendiente
  })
  const {
    data: paginatedData,
    columns,
    handleDelete,
    itemSelected,
    modalSelected,
    setItemSelected,
    setModalSelected
  } = config
  
  const onMarkAsDone=useCallback(()=>{
    setItemSelected(null)
    setModalSelected(null)
  },[])
  return (
    <>
      <SimpleTable
        data={paginatedData}
        columns={columns}
        pagination={false}
      />
      <DeleteModal
        open={itemSelected !== null && modalSelected === 'delete'}
        spanTitle="Eliminar"
        title='Movimiento Pendiente'
        onClose={() => {setItemSelected(null); setModalSelected(null)}}
        paragraph={`¿Esta seguro de eliminar el Movimiento Pendiente con ID: ${itemSelected?.id} ?`}
        onSubmit={handleDelete}
      >
        <span>Los movimientos pendientes eliminados estaran en la configuracion del sistema</span>
      </DeleteModal>
      <MarkAsDoneModal 
       open={itemSelected !== null && modalSelected === 'pagar'}
       onClose={()=> {setItemSelected(null); setModalSelected(null)}}
       onSubmit={onMarkAsDone}
       itemSelected={itemSelected}
      />
    </>
  )
}
