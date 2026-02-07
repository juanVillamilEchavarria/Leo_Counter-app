import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CuentaTable from "@/app/domains/cuenta/components/CuentaTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { Link } from "@inertiajs/react"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { CuentaRoutes } from "@/app/domains/cuenta"
import { useModalItem } from "@/app/shared/hooks"
import useCuenta from "@/app/domains/cuenta/hooks/useCuenta"
import { type Cuenta } from "@/app/domains/cuenta"

export default function Index({
  cuentas
}:{
  cuentas : {data: Cuenta[]}
}) {
  const {item, modal, open, close}= useModalItem<Cuenta>()
  const {handleSubmit}= useCuenta({method: 'delete', id: item?.id})

  return (
    <SectionTransition>
        <SectionDescription title="Cuentas" paragraph="Registra las cuentas de tu hogar y gestionalas " />
       <CreateButtonSection>
          <CrudButton
            as={Link}
            href={CuentaRoutes.create()}
            icon="fa-solid fa-wallet "
            />
        </CreateButtonSection>
        
        <div className="overflow-scroll scrollbar-modern">
            <CuentaTable data={cuentas.data} onSelect={(item, modalType)=>open(item,modalType)} />
        </div>

        <DeleteModal
          open={item !== null && modal === 'delete'}
          onClose={close}
          onSubmit={handleSubmit}
          spanTitle={'Archivar'}
          title={' Cuenta'}
          paragraph={`¿Esta seguro de eliminar la Cuenta: ${item?.nombre} ?`}
        >
          <small>las cuentas archivadas estaran en la configuracion del sistema</small>
        </DeleteModal>
    </SectionTransition>
  )
}
