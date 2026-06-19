/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
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
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"

export default function Index({
  cuentas
}:{
  cuentas : {data: Cuenta[]}
}) {
  const {item, modal, open, close, setItem}= useModalItem<Cuenta>()
  const {handleSubmit}= useCuenta({method: 'delete', id: item?.id})
  const descriptionItems=[
    {
      title: 'Saldos en tiempo real',
      description: 'Cuando se registra un movimiento que usa una cuenta, esta automaticamente actualizara su saldo reflejando el efecto de la transaccion realizada, asi siempre tendras un control en tiempo real de cuanto dinero tienes en cada una de tus cuentas',
      icon: 'fa-solid fa-wallet !text-yellow-400'
    },
    {
      title: 'Activa e inactiva',
      description: 'Marca tus cuentas como activas o inactivas, las cuentas inactivas no se mostraran en la hora de registrar un movimiento, pero no se eliminaran, para que puedas volver a activarlas cuando quieras, asi puedes mantener un historial de tus cuentas aunque ya no las uses',
      icon: 'fa-solid fa-toggle-on !text-blue-400'
    },
    {
      title : 'Restricciones de eliminacion',
      description: 'Las cuentas no se eliminan directamente desde aqui, si la marcas como eliminada, se ira a la papelera en configuracion, y desde alli, unicamente las que no tienen movimientos asociados podran ser eliminadas permanentemente (el acceso a configuracion es restringido unicamente para el administrador)',
      icon: 'fa-solid fa-ban !text-red-400'
    }
  ]

  return (
    <SectionTransition>
        <SectionDescriptionWithDetails
         principalTitle="Cuentas" 
        paragraph="Registra las cuentas de tu hogar y gestionalas " 
        items={descriptionItems}
        />
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
          onSubmit={(e)=>{handleSubmit(e) ; setItem(null)}}
          title={' Cuenta'}
          paragraph={`¿Esta seguro de eliminar la Cuenta: ${item?.nombre} ?`}
        >
          <small>las cuentas eliminadas estaran en la configuracion del sistema</small>
        </DeleteModal>
    </SectionTransition>
  )
}
