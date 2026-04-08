import { ConfiguracionNavBar } from "@/app/domains/configuracion"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import DeletedPresupuestoTable from "@/app/domains/configuracion/components/table/deleted/DeletedPresupuestoTable"
import Title from "@/app/shared/components/common/Title"
import {RestoreModal }from "@/app/domains/configuracion"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import {HardDeleteModalMessage} from "@/app/domains/configuracion"
import { useModalItem } from "@/app/shared/hooks"
import useConfiguracionActions from "@/app/domains/configuracion/hooks/useConfiguracionActions"
import { useCallback } from "react"
import { type PresupuestoHistoricoTableData } from "@/app/domains/presupuestoHistorico/types/presupuesto.types"
/**
 * Interfaz de presupuestos en la seccion de configuracion en soft deletes
 * @param {PresupuestoHistoricoTableData[]} data 
 * @returns {JSX.Element}
 */
export default function Presupuestos({
    data
}:{
    data: {data :PresupuestoHistoricoTableData[]}
}) {

  const {item, modal, open, close}= useModalItem<PresupuestoHistoricoTableData>()

  const {restore, hardDelete}= useConfiguracionActions()

  const handleRestore= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    restore('presupuestos', item?.id)
    close()
  },[restore, item])
  const handleHardDelete= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    hardDelete('presupuestos', item?.id)
    close()
  },[hardDelete, item])
  
  return (
    <SectionTransition>
      <ConfiguracionNavBar />
      <div className="mt-10 flex flex-col gap-5">
        <Title title="Presupuestos Eliminados" as={'h1'} size="3xl" />
        <DeletedPresupuestoTable 
          data={data.data} 
          onSelect={(item, modal) => open(item, modal)}
         />
          <RestoreModal
          open={item !== null && modal === 'restore'} 
          onClose={close} 
          paragraph={`¿Estás seguro de restaurar el presupuesto de ${item?.categoria} por $${item?.monto} ?`} 
          handleSubmit={handleRestore} 
          title="Presupuesto" /> 
          <DeleteModal
          open={item !== null && modal === 'delete'} 
          onClose={close} 
          onSubmit={handleHardDelete} 
          title="Presupuesto" 
          paragraph={`¿Estás seguro de eliminar el presupuesto de ${item?.categoria} por $${item?.monto} ?`} >
            <HardDeleteModalMessage />
          </DeleteModal>
        </div>
    </SectionTransition>
  )
}
