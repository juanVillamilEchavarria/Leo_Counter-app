import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { type UsuarioAdminFormProps } from "../types/usuario.types"

/**
 * Formulario reutilizable para creación y edición de usuarios en el módulo de administración.
 * En modo creación muestra campos de contraseña; en modo edición puede deshabilitar el campo email
 * si el usuario tiene una suscripción activa (isSuscribed).
 * @param data - Datos actuales del formulario.
 * @param setData - Función para actualizar los datos del formulario.
 * @param errors - Errores de validación del backend.
 * @param submit - Función de envío del formulario.
 * @param processing - Indica si el formulario está procesándose.
 * @param isSuscribed - Indica si el usuario tiene suscripción activa (deshabilita email).
 * @param isCreate - Indica si el formulario es de creación (muestra campos de contraseña).
 */
export default function UsuarioAdminForm({
    data,
    setData,
    errors,
    submit,
    processing,
    isSuscribed = false,
    isCreate = false,
}: UsuarioAdminFormProps) {
  return (
    <Card className="shadow-2xl! rounded-2xl!">
        <form onSubmit={submit} className="formulario-general">
            <legend className="legend mt-5">Información del usuario</legend>

            <div className="formulario-campo">
                <label htmlFor="name">Nombre</label>
                <InputFillable
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Nombre del usuario"
                    value={data?.name}
                    onChange={(e) => setData('name', e.target.value)}
                    className={`border-2 p-3 border-border text-foreground ${errors.name && 'border-red-500! text-red-500!'}`}
                    icon={`fa-solid fa-user fa-xl top-6 text-muted-foreground ${errors.name && 'text-red-500!'}`}
                />
                <TransitionMotion active={errors?.name}>
                    <AlertMessage message={errors?.name} />
                </TransitionMotion>
            </div>

            <div className="formulario-campo">
                <label htmlFor="email">E-mail</label>
                <InputFillable
                    type="text"
                    name="email"
                    id="email"
                    placeholder="E-mail del usuario"
                    value={data?.email}
                    onChange={(e) => setData('email', e.target.value)}
                    disabled={isSuscribed}
                    className={`border-2 p-3 border-border text-foreground ${errors.email && 'border-red-500! text-red-500!'} ${isSuscribed ? 'bg-muted cursor-not-allowed' : ''}`}
                    icon={isSuscribed ? 'fa-solid fa-lock text-2xl' : `fa-solid fa-envelope fa-xl top-6 text-muted-foreground ${errors.email && 'text-red-500!'}`}
                />
                <TransitionMotion active={errors?.email}>
                    <AlertMessage message={errors?.email} />
                </TransitionMotion>
                {isSuscribed && (
                    <p className="text-red-400 dark:text-red-200 mt-2 text-xs">
                        No puedes actualizar este campo, ya que el usuario está suscrito a un canal de notificación que lo implementa.
                    </p>
                )}
            </div>

            {isCreate && (
                <>
                    <div className="formulario-campo">
                        <label htmlFor="password">Contraseña</label>
                        <InputFillable
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Contraseña"
                            value={data?.password ?? ''}
                            onChange={(e) => setData('password', e.target.value)}
                            className={`border-2 p-3 border-border text-foreground ${errors.password && 'border-red-500! text-red-500!'}`}
                            icon={`fa-solid fa-lock fa-xl top-6 text-muted-foreground ${errors.password && 'text-red-500!'}`}
                        />
                        <TransitionMotion active={errors?.password}>
                            <AlertMessage message={errors?.password} />
                        </TransitionMotion>
                    </div>

                    <div className="formulario-campo">
                        <label htmlFor="password_confirmation">Confirmar Contraseña</label>
                        <InputFillable
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Confirmar Contraseña"
                            value={data?.password_confirmation ?? ''}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            className={`border-2 p-3 border-border text-foreground ${errors.password_confirmation && 'border-red-500! text-red-500!'}`}
                            icon={`fa-solid fa-lock fa-xl top-6 text-muted-foreground ${errors.password_confirmation && 'text-red-500!'}`}
                        />
                        <TransitionMotion active={errors?.password_confirmation}>
                            <AlertMessage message={errors?.password_confirmation} />
                        </TransitionMotion>
                    </div>
                </>
            )}

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
