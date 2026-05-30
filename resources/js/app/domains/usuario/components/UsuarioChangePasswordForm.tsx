/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { type UsuarioChangePasswordFormProps } from "../types/usuario.types"

/**
 * Formulario de cambio de contraseña de un usuario en el módulo de administración.
 * No requiere la contraseña actual (a diferencia del cambio de contraseña propio).
 * @param data - Datos actuales del formulario (password, password_confirmation).
 * @param setData - Función para actualizar los datos del formulario.
 * @param errors - Errores de validación del backend.
 * @param submit - Función de envío del formulario.
 * @param processing - Indica si el formulario está procesándose.
 */
export default function UsuarioChangePasswordForm({
    data,
    setData,
    errors,
    submit,
    processing,
}: UsuarioChangePasswordFormProps) {
  return (
    <Card className="shadow-2xl! rounded-2xl!">
        <form onSubmit={submit} className="formulario-general">
            <legend className="legend mt-5">Cambiar contraseña</legend>

            <div className="formulario-campo">
                <label htmlFor="password">Contraseña Nueva</label>
                <InputFillable
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Nueva Contraseña"
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
                <label htmlFor="password_confirmation">Repetir Contraseña</label>
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

            <div className="w-2/4 mt-15 mx-auto">
                <Button
                    variant="secondary"
                    type="submit"
                    disabled={processing}
                >
                    Cambiar contraseña
                </Button>
            </div>
        </form>
    </Card>
  )
}
