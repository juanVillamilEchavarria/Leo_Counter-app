import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import Button from "@/app/shared/components/common/Button"
import { type CuentaFormProps } from "../types/cuenta.types"
import { type CuentaFormData } from "../types/cuenta.types"
export default function CuentasForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: CuentaFormProps) {
  return (
  
        <form action="" className="formulario-general">
            <Card
            className="shadow-2xl! rounded-2xl!"
            >
            <legend className="legend mt-5">Informacion de la cuenta</legend>
            <div className="formulario-campo">
                <label htmlFor="nombre">Nombre</label>
                <InputFillable 
                    placeholder="Ej: Cuenta Mamá"
                    type="text"
                    name="nombre"
                    id="nombre"
                    value={data?.nombre}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('nombre', e.target.value)}
                    className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.name && 'border-red-500! text-red-500!'} `}
                    icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.name && 'text-red-500!'} `}
                />
            </div>
            <div className="formulario-campo">
                <label htmlFor="saldo_inicial">Saldo Inicial</label>
                <InputFillable 
                    placeholder="Ej: 1000"
                    type="number"
                    name="saldo_inicial"
                    id="saldo_inicial"
                    value={data?.saldo_inicial}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('saldo_inicial', e.target.value)}
                    className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.saldo_inicial && 'border-red-500! text-red-500!'} `}
                    icon={`fa-solid fa-coins fa-xl top-6 text-gray-400 ${errors.saldo_inicial && 'text-red-500!'} `}
                />
            </div>
            <div className="formulario-campo">
                <label htmlFor="tipo_cuenta_id">Tipo De Cuentas</label>
                <select className="select" name="tipo_cuenta_id" id="tipo_cuenta_id">
                    <option value="">--Seleccione--</option>
                    {options?.tipos_cuentas?.map((tipo_cuenta) => (
                        <option key={tipo_cuenta.id} value={tipo_cuenta.id}>{tipo_cuenta.tipo_cuenta}</option>
                    ))}
                </select>
            </div>
            <div className="formulario-campo">
                <label htmlFor="propietario_id">Propietario</label>
                <select className="select" name="propietario_id" id="propietario_id">
                    <option value="">--Seleccione--</option>
                    {options?.propietarios?.map((propietario) => (
                        <option key={propietario.id} value={propietario.id}>{propietario.nombre}</option>
                    ))}
                </select>
            </div>
            <div className="formulario-campo">
                <label htmlFor="notas">Notas</label>
                <InputFillable 
                    placeholder="Ej: Donde mamá recibe el dinero"
                    type="text"
                    name="notas"
                    id="notas"
                    value={data?.notas}
                    onChange={(e: React.ChangeEvent<HTMLInputElement>) => setData('notas', e.target.value)}
                    className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.notas && 'border-red-500! text-red-500!'} `}
                    icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.notas && 'text-red-500!'} `}
                />
            </div>
               </Card>

            <div className="w-1/6 mt-5 mx-auto">
                <Button
                variant="success"
                    type="submit"
                    disabled={processing}
                >
                    Guardar
                </Button>
            </div>

        </form>
 

  )
}
