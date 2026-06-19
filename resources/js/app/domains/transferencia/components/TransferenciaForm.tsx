/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import SaldoValidationFeedback from "../../movimientoEspontaneo/components/SaldoValidationFeedback";
import InputFillable from "@/app/shared/components/form/InputFillable";
import SelectModel from "@/app/shared/components/form/SelectModel";
import TextArea from "@/app/shared/components/form/TextArea";
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion";
import AlertMessage from "@/app/shared/components/common/AlertMessage";
import Button from "@/app/shared/components/common/Button";
import { type TransferenciaFormProps } from "../types/transferencia.types";
import useFormSaldoValidate from "../../movimientoEspontaneo/hooks/useFormSaldoValidate";
import { TiposMovimientoEnum } from "../../tipoMovimiento";
import { useEffect, useState } from "react";

export default function TransferenciaForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: TransferenciaFormProps) {
    const {data: dataValidate,error, isError}= useFormSaldoValidate({ cuentaId: data?.cuenta_origen_id, monto: data?.monto, tipo_movimiento_id: TiposMovimientoEnum.GASTO })
    const [cuentasDestino, setCuentasDestino] = useState<{ id: string, nombre: string }[]>(options.cuentas || [])
    useEffect(() => {
        if(data?.cuenta_origen_id) {
            const filtered = options.cuentas.filter(cuenta => cuenta.id !== data.cuenta_origen_id)
            setCuentasDestino(filtered)
        }
    }, [data?.cuenta_origen_id, options.cuentas])
  return (
        <form onSubmit={submit} className="formulario-general">
            <legend>Información de la Transferencia</legend>
            
            <div className="flex w-full flex-col gap-4 md:flex-row">
                <div className="formulario-campo w-full">
                    <label htmlFor="cuenta_origen_id">Cuenta Enviadora (Origen)</label>
                    <SelectModel
                        name="cuenta_origen_id"
                        id="cuenta_origen_id"
                        iterable={options.cuentas}
                        onChange={(e) => setData('cuenta_origen_id', e.target.value)}
                        value={data?.cuenta_origen_id}
                        className={`${errors.cuenta_origen_id && 'border-red-500! text-red-500!'}`}
                        placeholder="Seleccione una cuenta"
                    />
                    <TransitionMotion active={errors?.cuenta_origen_id}>
                        <AlertMessage message={errors?.cuenta_origen_id} />
                    </TransitionMotion>
                    {/* Error de API */}
                    <TransitionMotion active={isError}>
                        <AlertMessage message={error?.message || 'Error al validar saldo'} />
                    </TransitionMotion>

                    {/* Saldo insuficiente */}
                    <TransitionMotion active={dataValidate?.allowed !== undefined}>
                        <SaldoValidationFeedback allowed={dataValidate?.allowed} />
                    </TransitionMotion>
                </div>
                
                <div className="formulario-campo w-full">
                    <label htmlFor="cuenta_destino_id">Cuenta Receptora (Destino)</label>
                    <SelectModel
                        name="cuenta_destino_id"
                        id="cuenta_destino_id"
                        iterable={cuentasDestino}
                        onChange={(e) => setData('cuenta_destino_id', e.target.value)}
                        value={data?.cuenta_destino_id}
                        className={`${errors.cuenta_destino_id && 'border-red-500! text-red-500!'}`}
                        placeholder="Seleccione una cuenta"
                    />
                    <TransitionMotion active={errors?.cuenta_destino_id}>
                        <AlertMessage message={errors?.cuenta_destino_id} />
                    </TransitionMotion>
                </div>
            </div>

            <div className="formulario-campo">
                <label htmlFor="monto">Monto</label>
                <InputFillable
                    type="number"
                    name="monto"
                    id="monto"
                    value={data?.monto}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('monto', Number(e.target.value))}
                    className={`${errors.monto && 'border-red-500! text-red-500!'}`}
                    icon={`fa-solid fa-money-bill fa-xl top-6 text-muted-foreground ${errors.monto && 'text-red-500!'}`}
                />
                <TransitionMotion active={errors?.monto}>
                    <AlertMessage message={errors?.monto} />
                </TransitionMotion>
            </div>

            <div className="formulario-campo">
                <label htmlFor="descripcion">Descripción</label>
                <TextArea
                    name="descripcion"
                    id="descripcion"
                    value={data?.descripcion}
                    placeholder="Ej: Transferencia para ahorros"
                    icon={`fa-solid fa-note-sticky fa-xl top-6 text-muted-foreground ${errors.descripcion && 'text-red-500!'}`}
                    onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)}
                    className={`h-40 ${errors.descripcion && 'border-red-500! text-red-500!'}`}
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
                    Transferir
                </Button>
            </div>
        </form>
  )
}
