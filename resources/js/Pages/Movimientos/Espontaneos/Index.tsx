import { MovimientoEspontaneoTable, type MovimientoEspontaneoTableData , MovimientoEspontaneoRoutes, useMovimientoEspontaneo} from "@/app/domains/movimientoEspontaneo"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import InputFillable from "@/app/shared/components/form/InputFillable"
import { useModalItem } from "@/app/shared/hooks"
import { Link } from "@inertiajs/react"
import { dateFormat } from "@/app/shared/helpers"
export default function Index({
    dia,
    movimientos
}:{
    dia: string
    movimientos: {data:MovimientoEspontaneoTableData []}
}) {
    const {item, modal, open, close, setItem}= useModalItem<MovimientoEspontaneoTableData>()
    const {handleSubmit, form}= useMovimientoEspontaneo({method: 'delete', id: item?.id})
    const {setData, data}= form
    const handleClose = ()=>{
        close()
         setData('password', '')
    }
    console.log(data);
  return (
        <SectionTransition>
            <SectionDescription title="Movimientos Espontaneos" paragraph={(
                <span>Gestiona tus movimientos del dia de hoy <span className="font-bold">{dateFormat(dia)}</span></span>
            )} />
            <CreateButtonSection>
                <CrudButton
                    as={Link}
                    href={MovimientoEspontaneoRoutes.create()}
                    icon="fa-solid fa-calendar-day"
                >
                </CrudButton>
            </CreateButtonSection>
            <MovimientoEspontaneoTable data={movimientos.data} onSelect={(item, modalType)=> open(item,modalType)} />
            <DeleteModal  open={item !== null && modal === 'delete'} onClose={handleClose} title="Movimiento Espontaneo" spanTitle="Eliminar" paragraph={`¿Esta seguro de eliminar el movimiento espontaneo con ID: ${item?.id} ?`} onSubmit={handleSubmit} size="xl"  className="w-150">
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
