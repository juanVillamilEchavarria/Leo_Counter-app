import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import TextArea from "@/app/shared/components/form/TextArea"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import Button from "@/app/shared/components/common/Button"
import SelectModel from "@/app/shared/components/form/SelectModel"
import useMovimientoFijoForm from "../hooks/useMovimientoFijoForm"
import { dateToLocal } from "@/app/shared/helpers"
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
    today
   } = useMovimientoFijoForm({options, data})
   console.log(data);
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
                className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.nombre && 'border-red-500! text-red-500!'} `}
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
            <div className="formulario-campo w-full">
                <label htmlFor="frecuencia_id">Frecuencia</label>
                <SelectModel 
                    name="frecuencia_movimiento_id"
                    id="frecuencia_movimiento_id"
                    iterable={options.frecuencias_movimientos}
                    iterableOutput="frecuencia_movimiento"
                    onChange={(e) => setData('frecuencia_movimiento_id', e.target.value)}
                    value={data?.frecuencia_movimiento_id}
                    className={`${errors.frecuencia_movimiento_id && 'border-red-500! text-red-500!'}`}
                    placeholder="Seleccione una frecuencia"
                    />
                <TransitionMotion active={errors?.frecuencia_movimiento_id}>
                    <AlertMessage message={errors?.frecuencia_movimiento_id} />
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
                    className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.monto && 'border-red-500! text-red-500!'} `}
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
                    className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.fecha_proximo && 'border-red-500! text-red-500!'} `}
                ></InputFillable>

                <TransitionMotion active={errors?.fecha_proximo}>
                    <AlertMessage message={errors?.fecha_proximo} />
                </TransitionMotion>
            </div>
        </div>
        <TransitionMotion initial={{x:0, y:-30, opacity:0}}  exit={{x: 0, y:-30, opacity:0}} active={tipoMovimientoId==2}>
            <div className="formulario-campo">
                <label htmlFor="url_pago">Url de pago</label>
                <small>Opcional si aplica</small>
                <InputFillable
                    type="text"
                    name="url_pago"
                    id="url_pago"
                    value={data?.url_pago}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('url_pago', e.target.value)}  
                    className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.url_pago && 'border-red-500! text-red-500!'} `}
                ></InputFillable>

                <TransitionMotion active={errors?.url_pago}>
                    <AlertMessage message={errors?.url_pago} />
                </TransitionMotion>
            </div>
        </TransitionMotion>
        <div className="formulario-campo">
            <label htmlFor="descripcion">Descripcion</label>
            <TextArea
                name="descripcion"
                id="descripcion"
                value={data?.descripcion}
                placeholder="Ej: Movimiento fijo del pago de la empleada, cada 15 dias, sale del bolsillo de mamá"
                icon={`fa-solid fa-note-sticky fa-xl top-6 text-gray-400 ${errors.descripcion && 'text-red-500!'} `}
                onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)}
                className={`border-2 p-3 border-gray-300 text-gray-800 h-60 ${errors.descripcion && 'border-red-500! text-red-500!'} `}
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
