import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { Link } from "@inertiajs/react"
import { PresupuestoMesActualTable } from "@/app/domains/presupuestoMesActual"
import { PresupuestoMesActualRoutes, type PresupuestoMesActualTableData } from "@/app/domains/presupuestoMesActual"
import { dateFormat, normalizePeriod } from "@/app/shared/helpers"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import DuplicateModal from "@/app/domains/presupuestoMesActual/components/DuplicateModal"
import { useModalItem } from "@/app/shared/hooks"
import usePresupuestoMesActual from "@/app/domains/presupuestoMesActual/hooks/usePresupuestoMesActual"

export default function Index({
    periodo,
    presupuestos
}: {
    periodo: Date | string,
    presupuestos: { data: PresupuestoMesActualTableData[] }
}) {
    const {item, modal, open, close}= useModalItem<PresupuestoMesActualTableData>()
    const {handleSubmit}= usePresupuestoMesActual({method: 'delete', id: item?.id})

    return (
        <SectionTransition>
            <SectionDescription 
                title="Presupuestos Del Mes" 
                paragraph={(
                    <div>
                        <p>Gestiona Tus Presupuestos del Mes de <span className="font-bold capitalize">{dateFormat(normalizePeriod(periodo), 'MMMM YYYY')}</span></p>
                    </div>
                )} 
            />
            <CreateButtonSection>
                <CrudButton
                    as={Link}
                    href={PresupuestoMesActualRoutes.create()}
                    icon="fa-solid fa-calendar-day"
                >
                </CrudButton>
            </CreateButtonSection>
            <PresupuestoMesActualTable data={presupuestos.data} onSelect={(item, modalType)=>open(item,modalType)} />
            
            <DeleteModal
              open={item !== null && modal === 'delete'}
              onClose={close}
              onSubmit={handleSubmit}
              spanTitle={'Eliminar'}
              title={' Presupuesto'}
              paragraph={`¿Esta seguro de eliminar el Presupuesto de: ${item?.categoria} (${item?.descripcion || 'Sin descripción'}) ?`}
            >
              <small>Los presupuestos eliminados estaran en la configuración del sistema</small>
            </DeleteModal>
           <DuplicateModal 
           open={item !== null && modal === 'duplicate'}
           onClose={close}
           itemSelected={item}
           />
        </SectionTransition>
    )
}
