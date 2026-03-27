import Button from "@/app/shared/components/common/Button"
import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import { type FormCommonProps } from "@/app/shared/types/components"
import { type Propietario } from "../types/propietario.types"

export default function PropietarioForm({
     data,
    setData,
    errors,
    submit,
    processing,
}: FormCommonProps<Propietario>) {
  return (
    <Card>
        <form onSubmit={submit}className="formulario-general">
            <legend className="legend">Informacion del propietario</legend>
            <div className="flex w-full gap-3">
                <div className="formulario-campo w-full">
                        <label htmlFor="nombre">Nombre</label>
                        <InputFillable 
                            placeholder="Ej: Juan Perez"
                            type="text"
                            name="nombre"
                            id="nombre"
                            value={data?.nombre}
                            onChange={
                                (e: React.ChangeEvent<HTMLInputElement>) => setData('nombre', e.target.value)
                            }
                            className={`border-2 p-3 border-border text-gray-800 ${errors.nombre && 'border-red-500! text-red-500!'} `}
                            icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.nombre && 'text-red-500!'} `}
                        />
                        <TransitionMotion    active={errors?.nombre}>
                                <AlertMessage message={errors?.nombre} />
                        </TransitionMotion>
                        
                 </div>
                    <div className="formulario-campo w-full">
                        <label htmlFor="apellido">Apellido</label>
                        <InputFillable 
                            placeholder="Ej: Perez"
                            type="text"
                            name="apellido"
                            id="apellido"
                            value={data?.apellido}
                            onChange={
                                (e: React.ChangeEvent<HTMLInputElement>) => setData('apellido', e.target.value)
                            }
                            className={`border-2 p-3 border-border text-gray-800 ${errors.apellido && 'border-red-500! text-red-500!'} `}
                            icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.apellido && 'text-red-500!'} `}
                        />
                        <TransitionMotion   active={errors?.apellido}>
                                <AlertMessage message={errors?.apellido} />
                        </TransitionMotion>
                    </div>

            </div>
            
            <div className="formulario-campo">
                <label htmlFor="email">Email</label>
                <InputFillable 
                    placeholder="Ej: juanperez@example.com"
                    type="email"
                    name="email"
                    id="email"
                    value={data?.email}
                    onChange={
                        (e: React.ChangeEvent<HTMLInputElement>) => setData('email', e.target.value)
                    }
                    className={`border-2 p-3 border-border text-gray-800 ${errors.email && 'border-red-500! text-red-500!'} `}
                    icon={`fa-solid fa-envelope fa-xl top-6 text-gray-400 ${errors.email && 'text-red-500!'} `}
                />
                    
                    <TransitionMotion   active={errors?.email}>
                                <AlertMessage message={errors?.email} />
                        </TransitionMotion>
            </div>
            <div className="formulario-campo">
                <label htmlFor="telefono">Teléfono</label>
                <InputFillable 
                    placeholder="Ej: 123456789"
                    type="text"
                    name="telefono" 
                    id="telefono"
                    value={data?.telefono}
                    onChange={
                        (e: React.ChangeEvent<HTMLInputElement>) => setData('telefono', e.target.value)
                    }
                    className={`border-2 p-3 border-border text-gray-800 ${errors.telefono && 'border-red-500! text-red-500!'} `}
                    icon={`fa-solid fa-phone fa-xl top-6 text-gray-400 ${errors.telefono && 'text-red-500!'} `}
                />
                <TransitionMotion    active={errors?.telefono}>
                                <AlertMessage message={errors?.telefono} />
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
