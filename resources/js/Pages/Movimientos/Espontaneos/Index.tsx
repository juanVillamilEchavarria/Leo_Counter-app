/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
import { MovimientoEspontaneoTable, type MovimientoEspontaneoTableData , MovimientoEspontaneoRoutes, useMovimientoEspontaneo} from "@/app/domains/movimientoEspontaneo"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import InputFillable from "@/app/shared/components/form/InputFillable"
import { useModalItem } from "@/app/shared/hooks"
import { Link } from "@inertiajs/react"
import { dateFormat } from "@/app/shared/helpers"
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"
export default function Index({
    dia,
    movimientos
}:{
    dia: string
    movimientos: {data:MovimientoEspontaneoTableData []}
}) {
    const {item, modal, open, close, setItem}= useModalItem<MovimientoEspontaneoTableData>()
    const {handleMovimientoDelete, form}= useMovimientoEspontaneo({id: item?.id})
    const {setData, data}= form
    const descriptionItems=[
        {
            title: '¿Que son los movimientos espontaneos?',
            description: 'Los movimientos espontaneos son aquellos que registras en el mismo dia que ocurren, para llevar un control mas preciso de tus finanzas diarias, estos se registran directamente en el historial de movimientos',
            icon: 'fa-solid fa-bolt !text-yellow-300'
        },
        {
            title: 'Ten mucha precaucion al eliminar movimientos espontaneos',
            description: 'Los movimientos espontaneos eliminados no son recuperables y pueden afectar directamente a tus reportes, ten mucha precaucion al eliminar un movimiento espontaneo, ya que revierte directamente todo el proceso de transaccion entre cuentas que esten asociadas a este movimiento',
            icon: 'fa-solid fa-triangle-exclamation !text-red-400'
        }
    ]
    const handleClose = ()=>{
        close()
         setData('password', '')
    }
  return (
        <SectionTransition>
            <SectionDescriptionWithDetails 
            principalTitle="Movimientos Espontaneos" 
            paragraph={(
                <span>Gestiona tus movimientos del dia de hoy <span className="font-bold">{dateFormat(dia)}</span></span>
            )} 
            items={descriptionItems}
            />
            <CreateButtonSection>
                <CrudButton
                    as={Link}
                    href={MovimientoEspontaneoRoutes.create()}
                    icon="fa-solid fa-calendar-day"
                >
                </CrudButton>
            </CreateButtonSection>
            <MovimientoEspontaneoTable data={movimientos.data} onSelect={(item, modalType)=> open(item,modalType)} />
            <DeleteModal  open={item !== null && modal === 'delete'} onClose={handleClose} title="Movimiento Espontaneo" spanTitle="Eliminar" paragraph={<p>¿Esta seguro de eliminar el movimiento espontaneo con el nombre <span className="font-bold">{item?.nombre}</span>?</p>} onSubmit={handleMovimientoDelete}>
                <div className="flex flex-col gap-4 my-2">
                    <p>Los movimientos eliminados <span className="font-bold">NO SON RECUPERABLES Y PUEDEN AFECTAR DIRECTAMENTE A TUS REPORTES</span> </p>
                    <div className="formulario-campo gap-4">
                        <label htmlFor="password">Ingresa tu password para completar la accion</label>
                        <InputFillable placeholder="Tu Password" icon="fa-solid fa-lock text-2xl" type="password" onChange={(e)=>setData('password', e.target.value)} name="password" id="password_delete_movimiento_confirmation" value={data?.password || ''}></InputFillable>
                    </div>

                </div>

                </DeleteModal>
        </SectionTransition>
  )
}
