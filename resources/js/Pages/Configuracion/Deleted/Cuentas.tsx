import { ConfiguracionNavBar } from "@/app/domains/configuracion"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import DeletedCuentaTable from "@/app/domains/configuracion/components/table/deleted/DeletedCuentaTable"
import Title from "@/app/shared/components/common/Title"
import {RestoreModal }from "@/app/domains/configuracion"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import {HardDeleteModalMessage} from "@/app/domains/configuracion"
import { useModalItem } from "@/app/shared/hooks"
import useConfiguracionActions from "@/app/domains/configuracion/hooks/useConfiguracionActions"
import { useCallback } from "react"
import { type Cuenta } from "@/app/domains/cuenta"
/**
 * Interfaz de cuentas en la seccion de configuracion en soft deletes
 * @param {Cuenta[]} data 
 * @returns {JSX.Element}
 */
export default function Cuentas({
    data
}:{
    data: {data :Cuenta[]}
}) {

  const {item, modal, open, close}= useModalItem<Cuenta>()

  const {restore, hardDelete}= useConfiguracionActions()

  const handleRestore= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    restore('cuentas', item?.id)
    close()
  },[restore, item])
  const handleHardDelete= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    hardDelete('cuentas', item?.id)
    close()
  },[hardDelete, item])

  return (
    <SectionTransition>
      <ConfiguracionNavBar />
      <div className="mt-10 flex flex-col gap-5">
        <Title title="Cuentas Eliminadas" as={'h1'} size="3xl" />
        <DeletedCuentaTable 
          data={data.data} 
          onSelect={(item, modal) => open(item, modal)}
         />
          <RestoreModal
          open={item !== null && modal === 'restore'} 
          onClose={close} 
          paragraph={`¿Estas seguro de restaurar la cuenta: ${item?.nombre} ?`} 
          handleSubmit={handleRestore} 
          title="Cuenta" /> 
          <DeleteModal
          open={item !== null && modal === 'delete'} 
          onClose={close} 
          onSubmit={handleHardDelete} 
          title="Cuenta" 
          paragraph={`¿Estas seguro de eliminar la cuenta: ${item?.nombre} ?`} >
            <HardDeleteModalMessage />
          </DeleteModal>
        </div>
    </SectionTransition>
  )
}
