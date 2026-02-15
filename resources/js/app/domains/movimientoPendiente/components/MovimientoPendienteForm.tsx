import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import TextArea from "@/app/shared/components/form/TextArea"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import Button from "@/app/shared/components/common/Button"
import SelectModel from "@/app/shared/components/form/SelectModel"
import { useMemo } from "react"
import { useCategoriasMovimientoFilter } from "@/app/shared/hooks"
import { dateToLocal, today as todayFunction } from "@/app/shared/helpers"
import { type MovimientoPendienteFormProps } from "../types/movimientoPendiente.types"

export default function MovimientoPendienteForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: MovimientoPendienteFormProps) {
   const {
    tipoMovimientoId,
    setTipoMovimientoId,
    categoriasFiltered,
   } = useCategoriasMovimientoFilter({
        options,
        data,
        onCategoriaInvalid : () => setData('categoria_id', undefined)

})
    const today= useMemo(()=>{
                   return todayFunction();
               },[])

  return (
    <Card>
    <form onSubmit={submit} className="formulario-general">
        <legend className="legend mt-5">Información del movimiento pendiente</legend>
        <div className="formulario-campo">
            <label htmlFor="nombre">Nombre del movimiento pendiente</label>
            <InputFillable 
                placeholder="Ej: Pago de servicios"
                type="text"
                name="nombre"
                id="nombre"
                value={data?.nombre}
                onChange={
                    (e: React.ChangeEvent<HTMLInputElement>) => setData('nombre', e.target.value)
                }
                className={` ${errors.nombre && 'border-red-500! text-red-500!'} `}
                icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.nombre && 'text-red-500!'} `}
            />
            <TransitionMotion active={errors?.nombre}>
                <AlertMessage message={errors?.nombre} />
            </TransitionMotion>
        </div>
        <div className="flex w-full gap-4">
            <div className="formulario-campo w-full">
                <label htmlFor="tipo_movimiento_id">Tipo de movimiento</label>
               
                    <SelectModel 
                    name="tipo_movimiento_id"
                    id="tipo_movimiento_id"
                    iterable={options.tipos_movimientos}
                    iterableOutput="tipo_movimiento"
                    onChange={(e) => {
                        setTipoMovimientoId(Number(e.target.value));
                        setData('tipo_movimiento_id', Number(e.target.value));
                    }}
                    value={tipoMovimientoId}
                    className={`${errors.tipo_movimiento_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione un tipo de movimiento"
                    />
                        <TransitionMotion active={errors?.tipo_movimiento_id}>
                            <AlertMessage message={errors?.tipo_movimiento_id} />
                        </TransitionMotion>
            </div>
            <div className="formulario-campo w-full">
                <label htmlFor="categoria_id">Categoría</label>
                
                <SelectModel 
                    name="categoria_id"
                    id="categoria_id"
                    iterable={categoriasFiltered}
                    onChange={(e) => setData('categoria_id', Number(e.target.value))}
                    value={data?.categoria_id}
                    className={`${errors.categoria_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione una categoría"
                    />
                <TransitionMotion active={errors?.categoria_id}>
                    <AlertMessage message={errors?.categoria_id} />
                </TransitionMotion>
            </div>
        </div>
        <div className="flex w-full gap-4">
            <div className="formulario-campo w-full">
                <label htmlFor="cuenta_id">Cuenta</label>
                
                <SelectModel 
                    name="cuenta_id"
                    id="cuenta_id"
                    iterable={options.cuentas}
                    onChange={(e) => setData('cuenta_id', Number(e.target.value))}
                    value={data?.cuenta_id}
                    className={`${errors.cuenta_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione una cuenta"
                    />
                <TransitionMotion active={errors?.cuenta_id}>
                    <AlertMessage message={errors?.cuenta_id} />
                </TransitionMotion>
            </div>
        </div>
        <div className="flex w-full gap-4">
            <div className="formulario-campo w-full">
                <label htmlFor="monto">Monto</label>
                <InputFillable
                    type="number"
                    name="monto"
                    id="monto"
                    value={data?.monto}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('monto', Number(e.target.value))}
                    className={` ${errors.monto && 'border-red-500! text-red-500!'} `}
                ></InputFillable>

                <TransitionMotion active={errors?.monto}>
                    <AlertMessage message={errors?.monto} />
                </TransitionMotion>

            </div>
            <div className="formulario-campo w-full">
                <label htmlFor="fecha_programada">Fecha Programada</label>
                <InputFillable
                    type="date"
                    name="fecha_programada"
                    id="fecha_programada"
                    min={today}
                    value={data?.fecha_programada ? dateToLocal(data?.fecha_programada) : ''}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('fecha_programada', e.target.value)}
                    className={` ${errors.fecha_programada && 'border-red-500! text-red-500!'} `}
                ></InputFillable>

                <TransitionMotion active={errors?.fecha_programada}>
                    <AlertMessage message={errors?.fecha_programada} />
                </TransitionMotion>
            </div>
        </div>
        <div className="formulario-campo">
            <label htmlFor="dias_aviso">Dias de aviso</label>
            <small className="text-gray-400">Ingresa la cantidad de dias en los que quieres ser notificado antes de la fecha programada, este campo es opcional</small>
            <InputFillable
                type="number"
                name="dias_aviso"
                id="dias_aviso"
                value={data?.dias_aviso ?? ''}
                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('dias_aviso', e.target.value ? Number(e.target.value) : null)}
                className={` ${errors.dias_aviso && 'border-red-500! text-red-500!'} `}
            ></InputFillable>

            <TransitionMotion active={errors?.dias_aviso}>
                <AlertMessage message={errors?.dias_aviso} />
            </TransitionMotion>
        </div>
        <div className="formulario-campo">
            <label htmlFor="descripcion">Descripcion</label>
            <TextArea
                name="descripcion"
                id="descripcion"
                value={data?.descripcion}
                placeholder="Ej: Pago pendiente de servicios, debe pagarse antes del 15"
                icon={`fa-solid fa-note-sticky fa-xl top-6 text-gray-400 ${errors.descripcion && 'text-red-500!'} `}
                onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)}
                className={` h-60 ${errors.descripcion && 'border-red-500! text-red-500!'} `}
            />
            <TransitionMotion active={errors?.descripcion}>
                <AlertMessage message={errors?.descripcion} />
            </TransitionMotion>
        </div>
         
          <div className="w-1/6 my-5 mx-auto">
            <Button
            variant="secondary"
                type="submit"
                disabled={processing}
            >
                Guardar
            </Button>
        </div>
        </form>
    </Card>
  )
}
