import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import TextArea from "@/app/shared/components/form/TextArea"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import Button from "@/app/shared/components/common/Button"
import SelectModel from "@/app/shared/components/form/SelectModel"
import { useCategoriasMovimientoFilter } from "@/app/shared/hooks"
import { useMemo } from "react"
import { dateToLocal, today as todayFunction } from "@/app/shared/helpers"
import { type MovimientoFijoFormProps } from "../types/movimientoFijo.types"
export default function MovimientoFijoForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: MovimientoFijoFormProps) {
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
        <legend className="legend mt-5">Información del movimiento fijo</legend>
        <div className="formulario-campo">
            <label htmlFor="nombre">Nombre del movimiento fijo</label>
            <InputFillable
                placeholder="Ej: Pago de empleada"
                type="text"
                name="nombre"
                id="nombre"
                value={data?.nombre}
                onChange={
                    (e: React.ChangeEvent<HTMLInputElement>) => setData('nombre', e.target.value)
                }
                className={` ${errors.nombre && 'border-red-500! text-red-500!'} `}
                icon={`fa-solid fa-file-signature fa-xl top-6 text-muted-foreground ${errors.nombre && 'text-red-500!'} `}
            />
            <TransitionMotion active={errors?.nombre}>
                <AlertMessage message={errors?.nombre} />
            </TransitionMotion>
        </div>
        <div className="flex w-full flex-col gap-4 md:flex-row">
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
                    onChange={(e) => setData('categoria_id', e.target.value)}
                    value={data?.categoria_id}
                    className={`${errors.categoria_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione una categoría"
                    />
                <TransitionMotion active={errors?.categoria_id}>
                    <AlertMessage message={errors?.categoria_id} />
                </TransitionMotion>
            </div>
        </div>
        <div className="flex w-full flex-col gap-4 md:flex-row">
            <div className="formulario-campo w-full">
                <label htmlFor="cuenta_id">Cuenta</label>

                <SelectModel
                    name="cuenta_id"
                    id="cuenta_id"
                    iterable={options.cuentas}
                    onChange={(e) => setData('cuenta_id', e.target.value)}
                    value={data?.cuenta_id}
                    className={`${errors.cuenta_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione una cuenta"
                    />
                <TransitionMotion active={errors?.cuenta_id}>
                    <AlertMessage message={errors?.cuenta_id} />
                </TransitionMotion>
            </div>
            <div className="formulario-campo w-full">
                <label htmlFor="frecuencia_id">Frecuencia</label>
                <SelectModel
                    name="frecuencia_movimiento_id"
                    id="frecuencia_movimiento_id"
                    iterable={options.frecuencias_movimientos}
                    iterableOutput="frecuencia_movimiento"
                    onChange={(e) => setData('frecuencia_movimiento_id', Number(e.target.value))}
                    value={data?.frecuencia_movimiento_id}
                    className={`${errors.frecuencia_movimiento_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione una frecuencia"
                    />
                <TransitionMotion active={errors?.frecuencia_movimiento_id}>
                    <AlertMessage message={errors?.frecuencia_movimiento_id} />
                </TransitionMotion>
            </div>
        </div>
        <div className="flex w-full flex-col gap-4 md:flex-row">
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
                <label htmlFor="fecha_proximo">Fecha Proximo</label>
                <InputFillable
                    type="date"
                    name="fecha_proximo"
                    id="fecha_proximo"
                    min={today}
                    value={data?.fecha_proximo ? dateToLocal(data?.fecha_proximo) : ''}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('fecha_proximo', e.target.value)}
                    className={` ${errors.fecha_proximo && 'border-red-500! text-red-500!'} `}
                ></InputFillable>

                <TransitionMotion active={errors?.fecha_proximo}>
                    <AlertMessage message={errors?.fecha_proximo} />
                </TransitionMotion>
            </div>
        </div>
        <div className="formulario-campo">
            <label htmlFor="dias_aviso">Dias de aviso</label>
            <small className="text-muted-foreground">Ingresa la cantidad de dias en los que quieres ser notificado antes de la fecha del proximo, este campo es opcional</small>
            <InputFillable
                type="number"
                name="dias_aviso"
                id="dias_aviso"
                value={data?.dias_aviso}
                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('dias_aviso', Number(e.target.value))}
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
                placeholder="Ej: Movimiento fijo del pago de la empleada, cada 15 dias, sale del bolsillo de mamá"
                icon={`fa-solid fa-note-sticky fa-xl top-6 text-muted-foreground ${errors.descripcion && 'text-red-500!'} `}
                onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)}
                className={` h-60 ${errors.descripcion && 'border-red-500! text-red-500!'} `}
            />
            <TransitionMotion active={errors?.descripcion}>
                <AlertMessage message={errors?.descripcion} />
            </TransitionMotion>
        </div>

          <div className="w-full my-5 mx-auto sm:w-1/2 lg:w-1/6">
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
