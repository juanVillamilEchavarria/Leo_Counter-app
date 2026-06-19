/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import { PropietarioTable } from "@/app/domains/propietario"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import ShowModal from "@/app/shared/components/modal/ShowModal"
import { Link } from "@inertiajs/react"
import { PropietarioRoutes } from "@/app/domains/propietario"
import { type PropietarioShowData, type PropietarioTableData, ShowPropietarioModal } from "@/app/domains/propietario"
import { BaseIcons } from "@/app/shared/types"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useModalItem } from "@/app/shared/hooks"
import usePropietario from "@/app/domains/propietario/hooks/usePropietario"
import { useEffect } from "react"

export default function Index({
  propietarios,
  data 
}:{
  propietarios: {data:PropietarioTableData[]}
  data ?:  PropietarioShowData
}) {
  useEffect(()=>{
    if(data){
      setItem(data)
    }
  },[data])
  const {item, modal, open, close, setItem}= useModalItem<PropietarioShowData>()
  const {handleSubmit}= usePropietario({method: 'delete', id: item?.id})

  console.log(data)

  return (
    <SectionTransition>
        <SectionDescription title="Propietarios" paragraph="Gestiona los propietarios de las cuentas del sistema" />
        <CreateButtonSection>
          <CrudButton
            as={Link}
            href={PropietarioRoutes.create()}
            icon="fa-solid fa-users"
            />
        </CreateButtonSection>
        <PropietarioTable data={propietarios.data} onSelect={(item, modal)=>open(item,modal)} />
        
        <DeleteModal
          open={item !== null && modal === 'delete'}
          onClose={close}
          onSubmit={(e)=>{handleSubmit(e) ; setItem(null)}}
          spanTitle={'Eliminar'}
          title={' Propietario'}
          paragraph={`¿Esta seguro de eliminar el propietario: ${item?.nombre} ${item?.apellido} ?`}
        >
          <small>los propietarios eliminados no son recuperables, si este propietario esta asignado a una cuenta, no podra ser eliminado</small>
        </DeleteModal>
        <ShowPropietarioModal
        open={item !== null && modal === 'show'}
        item={item}
        onClose={close}
        />
    </SectionTransition>
  )
}
