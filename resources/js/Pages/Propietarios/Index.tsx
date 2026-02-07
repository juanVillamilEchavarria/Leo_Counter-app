import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import { PropietarioTable } from "@/app/domains/propietario"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { Link } from "@inertiajs/react"
import { PropietarioRoutes } from "@/app/domains/propietario"
import { type Propietario } from "@/app/domains/propietario"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useModalItem } from "@/app/shared/hooks"
import usePropietario from "@/app/domains/propietario/hooks/usePropietario"

export default function Index({
  propietarios
}:{
  propietarios: Propietario[]
}) {
  const {item, modal, open, close}= useModalItem<Propietario>()
  const {handleSubmit}= usePropietario({method: 'delete', id: item?.id})

  return (
    <SectionTransition>
        <SectionDescription title="Propietarios" paragraph="Gestiona Tus Propietarios" />
        <CreateButtonSection>
          <CrudButton
            as={Link}
            href={PropietarioRoutes.create()}
            icon="fa-solid fa-users"
            />
        </CreateButtonSection>
        <PropietarioTable data={propietarios} onSelect={(item, modalType)=>open(item,modalType)} />
        
        <DeleteModal
          open={item !== null && modal === 'delete'}
          onClose={close}
          onSubmit={handleSubmit}
          spanTitle={'Eliminar'}
          title={' Propietario'}
          paragraph={`¿Esta seguro de eliminar el propietario: ${item?.nombre} ${item?.apellido} ?`}
        >
          <small>los propietarios eliminados no son recuperables, si este propietario esta asignado a una cuenta, considera inmediatamente luego de esta accion asignarle un nuevo propietario</small>
        </DeleteModal>
    </SectionTransition>
  )
}
