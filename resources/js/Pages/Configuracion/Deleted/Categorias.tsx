/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { ConfiguracionNavBar } from "@/app/domains/configuracion"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import DeletedCategoriaTable from "@/app/domains/configuracion/components/table/deleted/DeletedCategoriaTable"
import Title from "@/app/shared/components/common/Title"
import {RestoreModal }from "@/app/domains/configuracion"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import {HardDeleteModalMessage} from "@/app/domains/configuracion"
import { useModalItem } from "@/app/shared/hooks"
import useConfiguracionActions from "@/app/domains/configuracion/hooks/useConfiguracionActions"
import { useCallback } from "react"
import { type CategoriaTableData } from "@/app/domains/categoria"
/**
 * Interfaz de categorías en la seccion de configuracion en soft deletes
 * @param {CategoriaTableData[]} data 
 * @returns {JSX.Element}
 */
export default function Categorias({
    data
}:{
    data: {data :CategoriaTableData[]}
}) {

  const {item, modal, open, close}= useModalItem<CategoriaTableData>()

  const {restore, hardDelete}= useConfiguracionActions()

  const handleRestore= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    restore('categorias', item?.id)
    close()
  },[restore, item])
  const handleHardDelete= useCallback((e: React.FormEvent<HTMLFormElement>)=>{
    e.preventDefault()
    hardDelete('categorias', item?.id)
    close()
  },[hardDelete, item])
  
  return (
    <SectionTransition>
      <ConfiguracionNavBar />
      <div className="mt-10 flex flex-col gap-5">
        <Title title="Categorías Eliminadas" as={'h1'} size="3xl" />
        <DeletedCategoriaTable 
          data={data.data} 
          onSelect={(item, modal) => open(item, modal)}
         />
          <RestoreModal
          open={item !== null && modal === 'restore'} 
          onClose={close} 
          paragraph={`¿Estas seguro de restaurar la categoría: ${item?.nombre} ?`} 
          handleSubmit={handleRestore} 
          title="Categoría" /> 
          <DeleteModal
          open={item !== null && modal === 'delete'} 
          onClose={close} 
          onSubmit={handleHardDelete} 
          title="Categoría" 
          paragraph={`¿Estas seguro de eliminar la categoría: ${item?.nombre} ?`} >
            <HardDeleteModalMessage />
          </DeleteModal>
        </div>
    </SectionTransition>
  )
}
