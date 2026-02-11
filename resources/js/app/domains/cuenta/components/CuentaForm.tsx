import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import TextArea from "@/app/shared/components/form/TextArea"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { type CuentaFormProps } from "../types/cuenta.types"
export default function CuentaForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
    can_update_saldo
}: CuentaFormProps) {
    console.log(errors)
  return (
    <Card
    className="shadow-2xl! rounded-2xl!"
    >
        <form onSubmit={submit} className="formulario-general">

            <legend className="legend mt-5">Informacion de la cuenta</legend>
            <div className="formulario-campo">
                <label htmlFor="nombre">Nombre</label>
                <InputFillable 
                    placeholder="Ej: Cuenta Mamá"
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
                <TransitionMotion
                 active={errors?.nombre}
                >
                    <AlertMessage message={errors?.nombre} />

                </TransitionMotion>

            </div>
            <div className="formulario-campo">
                <label htmlFor="saldo_inicial">Saldo Inicial</label>
                <InputFillable 
                    placeholder="Ej: 1000"
                    type="number"
                    name="saldo_inicial"
                    id="saldo_inicial"
                    disabled={can_update_saldo === false}
                    value={data?.saldo_inicial}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('saldo_inicial', Number(e.target.value))}
                    className={`
                            border-2 p-3 border-gray-300 text-gray-800
                            ${errors.saldo_inicial && 'border-red-500! text-red-500!'} 
                            ${can_update_saldo === false && 'bg-gray-200 cursor-not-allowed'} 
                         `}
                    icon={`fa-solid fa-coins fa-xl top-6 text-gray-400 ${errors.saldo_inicial && 'text-red-500!'} `}
                />
                <TransitionMotion
                 active={errors?.saldo_inicial}
                >
                    <AlertMessage message={errors?.saldo_inicial} />

                </TransitionMotion>
            </div>
            <div className="flex w-full gap-2">
                <div className="formulario-campo w-full">
                    <label htmlFor="tipo_cuenta_id">Tipo De Cuentas</label>
                    <select
                            className={`select ${errors.tipo_cuenta_id && 'border-red-500! text-red-500!'}`} 
                            name="tipo_cuenta_id" 
                            id="tipo_cuenta_id" 
                            value={data?.tipo_cuenta_id ?? ''}
                            onChange={(e:React.ChangeEvent<HTMLSelectElement>)=> setData('tipo_cuenta_id', Number(e.target.value))}
                        >
                        <option value="">--Seleccione--</option>
                        {options?.tipo_cuentas?.map((tipo_cuenta) => (
                            <option key={tipo_cuenta.id} value={tipo_cuenta.id}>{tipo_cuenta.tipo_cuenta}</option>
                        ))}
                    </select>

                    <TransitionMotion
                     active={errors?.tipo_cuenta_id}
                    >
                        <AlertMessage message={errors?.tipo_cuenta_id} />

                    </TransitionMotion>
                </div>
                <div className="formulario-campo w-full">
                    <label htmlFor="propietario_id">Propietario</label>
                    <select 
                        className={`select ${errors.propietario_id && 'border-red-500! text-red-500!'}`} 
                        name="propietario_id" 
                        id="propietario_id"
                        value={data?.propietario_id ?? ''}
                        onChange={(e:React.ChangeEvent<HTMLSelectElement>)=> setData('propietario_id', Number(e.target.value))}
                    >
                        <option value="">--Seleccione--</option>
                        {options?.propietarios?.map((propietario) => (
                            <option key={propietario.id} value={propietario.id}>{propietario.nombre}</option>
                        ))}
                    </select>

                    <TransitionMotion
                     active={errors?.propietario_id}
                    >
                        <AlertMessage message={errors?.propietario_id} />

                    </TransitionMotion>
                </div>
            </div>
            <div className="formulario-campo">
                <label htmlFor="notas">Notas</label>
               <TextArea
                name="notas"
                id="notas"
                value={data?.notas}
                onChange={(e: React.ChangeEvent<HTMLTextAreaElement>) => setData('notas', e.target.value)}
                className={`border-2 p-3 border-gray-300 text-gray-800 h-60 ${errors.notas && 'border-red-500! text-red-500!'} `}
                placeholder="Ej: Esta es la cuenta donde mamá paga"
                icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.notas && 'text-red-500!'} `}
               />
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
