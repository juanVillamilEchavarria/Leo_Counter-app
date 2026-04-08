import { ConfiguracionNavBar } from "@/app/domains/configuracion"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import DeletedMovimientoPendienteTable from "@/app/domains/configuracion/components/table/deleted/DeletedMovimientoPendienteTable"
import Title from "@/app/shared/components/common/Title"
import {RestoreModal }from "@/app/domains/configuracion"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import {HardDeleteModalMessage} from "@/app/domains/configuracion"
import { useModalItem } from "@/app/shared/hooks"
import useConfiguracionActions from "@/app/domains/configuracion/hooks/useConfiguracionActions"
import { useCallback } from "react"
import { type MovimientoPendienteTableData } from "@/app/domains/movimientoPendiente/types/movimientoPendiente.types"
/**
 * Interfaz de movimientos pendientes en la seccion de configuracion en soft deletes
 * @param {MovimientoPendienteTableData[]} data 
 * @returns {JSX.Element}
 */
export default function MovimientosPendientes({
    data
}:{
    data: {data :MovimientoPendienteTableData[]}
}) {

  const {item, modal, open, close}= useModalItem<MovimientoPendienteTableData>()

  const {restore, hardDelete}= useConfiguracionActions()

  const handleRestore= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    restore('movimientosPendientes', item?.id)
    close()
  },[restore, item])
  const handleHardDelete= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    hardDelete('movimientosPendientes', item?.id)
    close()
  },[hardDelete, item])
  
  return (
    <SectionTransition>
      <ConfiguracionNavBar />
      <div className="mt-10 flex flex-col gap-5">
        <Title title="Movimientos Pendientes Eliminados" as={'h1'} size="3xl" />
        <DeletedMovimientoPendienteTable 
          data={data.data} 
          onSelect={(item, modal) => open(item, modal)}
         />
          <RestoreModal
          open={item !== null && modal === 'restore'} 
          onClose={close} 
          paragraph={`¿Estás seguro de restaurar el movimiento pendiente: ${item?.nombre} ?`} 
          handleSubmit={handleRestore} 
          title="Movimiento Pendiente" /> 
          <DeleteModal
          open={item !== null && modal === 'delete'} 
          onClose={close} 
          onSubmit={handleHardDelete} 
          title="Movimiento Pendiente" 
          paragraph={`¿Estás seguro de eliminar el movimiento pendiente: ${item?.nombre} ?`} >
            <HardDeleteModalMessage />
          </DeleteModal>
        </div>
    </SectionTransition>
  )
}
