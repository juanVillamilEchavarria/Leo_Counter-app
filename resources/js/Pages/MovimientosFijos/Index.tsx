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
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { MovimientoFijoTable } from "@/app/domains/movimientoFijo"
import { Link } from "@inertiajs/react"
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo"
import { type MovimientoFijoTableData } from "@/app/domains/movimientoFijo"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { useModalItem } from "@/app/shared/hooks"
import useMovimientoFijo from "@/app/domains/movimientoFijo/hooks/useMovimientoFijo"

export default function Index({
  movimientos
}:{
  movimientos: {data: MovimientoFijoTableData[]}
}) {
  const {item, modal, open, close}= useModalItem<MovimientoFijoTableData>()
  const {handleSubmit}= useMovimientoFijo({method: 'delete', id: item?.id})

  return (
    <SectionTransition>
        <SectionDescription title="Movimientos Fijos" paragraph="Gestiona tus ingresos o gastos fijos " />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href={MovimientoFijoRoutes.create()}
                icon="fa-solid fa-diagram-project "
                />
        </CreateButtonSection>
        <MovimientoFijoTable data={movimientos.data} onSelect={(item, modalType)=>open(item,modalType)} />
        
        <DeleteModal
          open={item !== null && modal === 'delete'}
          spanTitle="Eliminar"
          title='Movimiento Fijo'
          onClose={close}
          paragraph={`¿Esta seguro de eliminar el Movimiento Fijo con ID: ${item?.id} ?`}
          onSubmit={handleSubmit}
        >
          <small>Los Movimientos fijos eliminados no se pueden recuperar, solo los movimientos fijos sin movimientos asociados pueden ser eliminados, si no lo usaras mas, mejor marcalo como inactivo</small>
        </DeleteModal>
    </SectionTransition>
  )
}
