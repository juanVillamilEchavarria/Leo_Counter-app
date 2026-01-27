import InputFillable from "@/app/shared/components/form/InputFillable"
import Card from "@/app/shared/components/common/Card"
import SelectModel from "@/app/shared/components/form/SelectModel"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import TextArea from "@/app/shared/components/form/TextArea"
import { dateToLocal, today, monthLimitFromToday } from "@/app/shared/helpers"
import { useMemo } from "react"
import { type PresupuestoPorPeriodoFormProps } from "../types/presupuestoPorPeriodo.types"


export default function PresupuestoPorPeriodoForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: PresupuestoPorPeriodoFormProps) {
    const todayDate= useMemo(()=>
        today(),
    [])
    const monthLimit= useMemo(()=>
        monthLimitFromToday(2),[todayDate]
    )
    return (
        <Card>
            <form onSubmit={submit} className="formulario-general">
                <legend className="legend mt-5">Información del presupuesto por período</legend>
                <div className="formulario-campo">
                    <label htmlFor="categoria_id">Categoría</label>
                    <SelectModel
                        name="categoria_id"
                        id="categoria_id"
                        value={data?.categoria_id}
                        onChange={
                            (e: React.ChangeEvent<HTMLSelectElement>) => setData('categoria_id', Number(e.target.value))
                        }
                        iterable={options.categorias}
                        className={` ${errors.categoria_id && 'border-red-500! text-red-500!'} `}
                    />
                    <TransitionMotion
                        active={errors?.categoria_id}>
                        <AlertMessage message={errors?.categoria_id} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="tipo_presupuesto_id">Tipo de Presupuesto</label>
                    <SelectModel
                        name="tipo_presupuesto_id"
                        id="tipo_presupuesto_id"
                        value={data?.tipo_presupuesto_id}
                        onChange={
                            (e: React.ChangeEvent<HTMLSelectElement>) => setData('tipo_presupuesto_id', Number(e.target.value))
                        }
                        iterable={options.tipo_presupuestos}
                        iterableOutput="tipo_presupuesto"
                        className={` ${errors.tipo_presupuesto_id && 'border-red-500! text-red-500!'} `}
                    />
                    <TransitionMotion
                        active={errors?.tipo_presupuesto_id}>
                        <AlertMessage message={errors?.tipo_presupuesto_id} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="monto">Monto</label>
                    <InputFillable 
                        placeholder="Ej: 1000"
                        type="number"
                        name="monto"
                        id="monto"
                        value={data?.monto}
                        onChange={
                            (e: React.ChangeEvent<HTMLInputElement>) => setData('monto', Number(e.target.value))
                        }
                        className={` ${errors.monto && 'border-red-500! text-red-500!'} `}
                        icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.monto && 'text-red-500!'} `}
                    />
                    <TransitionMotion
                        active={errors?.monto}>
                        <AlertMessage message={errors?.monto} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="fecha_inicio">Fecha Inicio</label>
                    <InputFillable 
                        type="date"
                        name="fecha_inicio"
                        id="fecha_inicio"
                        value={data?.fecha_inicio ? dateToLocal(data?.fecha_inicio) : ''}
                        min={todayDate}
                        onChange={
                            (e: React.ChangeEvent<HTMLInputElement>) => setData('fecha_inicio', e.target.value)
                        }
                        className={` ${errors.fecha_inicio && 'border-red-500! text-red-500!'} `}
                    />
                    <TransitionMotion
                        active={errors?.fecha_inicio}>
                        <AlertMessage message={errors?.fecha_inicio} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="fecha_final">Fecha Final</label>
                    <InputFillable 
                        type="date"
                        name="fecha_final"
                        id="fecha_final"
                        min={monthLimit}
                        value={data?.fecha_final ? dateToLocal(data?.fecha_final) : ''}
                        onChange={
                            (e: React.ChangeEvent<HTMLInputElement>) => setData('fecha_final', e.target.value)
                        }
                        className={` ${errors.fecha_final && 'border-red-500! text-red-500!'} `}
                    />
                    <TransitionMotion
                        active={errors?.fecha_final}>
                        <AlertMessage message={errors?.fecha_final} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="descripcion">Descripción (opcional)</label>
                    <TextArea
                        placeholder="Ej: Matrícula anual de colegio"
                        name="descripcion"
                        id="descripcion"
                        value={data?.descripcion || ''}
                        onChange={
                            (e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)
                        }
                        className={` h-50 ${errors.descripcion && 'border-red-500! text-red-500!'} `}
                        icon={`fa-solid fa-pen fa-xl top-6 text-gray-400 ${errors.descripcion && 'text-red-500!'} `}
                    />
                    <TransitionMotion
                        active={errors?.descripcion}>
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
