import Card from "@/app/shared/components/common/Card"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { type SuscriptorFormProps } from "../types/notificacion.types"
import useSuscriptorNotificacionFormOptionsApi from "../hooks/api/useSuscriptorNotificacionFormOptionsApi"
import SelectModel from "@/app/shared/components/form/SelectModel"

/**
 * Formulario para crear/editar un Suscriptor de Notificación.
 * Sigue el patrón de CuentaForm: recibe data, setData, errors, submit, processing y options
 * como props individuales (FormCommonProps + opciones).
 * @param {SuscriptorFormProps} props - Props del formulario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function SuscriptorNotificacionForm({
  data,
  setData,
  errors,
  submit,
  options,
  processing,
}: SuscriptorFormProps) {
  return (

      <form onSubmit={submit} className="formulario-general">
        <legend className="legend mt-5">Información del Suscriptor</legend>

        {/* Campo: Usuario */}
        <div className="formulario-campo">
          <label htmlFor="user_id">Usuario</label>
          <SelectModel
            name="user_id"
            id="user_id"
            value={data?.user_id ?? ''}
            onChange={(e: React.ChangeEvent<HTMLSelectElement>) => setData('user_id', e.target.value)}
            iterable={options?.usuarios ?? []}
            iterableOutput="name"
            placeholder="Seleccione un usuario"
            className={`select ${errors.user_id && 'border-red-500! text-red-500!'}`}
          />
         
          <TransitionMotion active={errors?.user_id}>
            <AlertMessage message={errors?.user_id} />
          </TransitionMotion>
        </div>

        {/* Campo: Canal */}
        <div className="formulario-campo">
          <label htmlFor="canal_notificacion_id">Canal</label>
          <SelectModel
            name="canal_notificacion_id"
            id="canal_notificacion_id"
            value={data?.canal_notificacion_id ?? ''}
            onChange={(e: React.ChangeEvent<HTMLSelectElement>) => setData('canal_notificacion_id', e.target.value)}
            iterable={options?.canales ?? []}
            placeholder="Seleccione un canal"
            className={`select ${errors.canal_notificacion_id && 'border-red-500! text-red-500!'}`}
          />
          <TransitionMotion active={errors?.canal_notificacion_id}>
            <AlertMessage message={errors?.canal_notificacion_id} />
          </TransitionMotion>
        </div>


        {/* Botón de envío */}
        <div className="w-full my-5 mx-auto sm:w-1/2">
          <Button
            variant="secondary"
            type="submit"
            disabled={processing}
          >
            Guardar
          </Button>
        </div>
      </form>
  )
}
