import Card from "@/app/shared/components/common/Card"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { type SuscriptorFormProps } from "../types/notificacion.types"

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
  processing,
  options
}: SuscriptorFormProps) {

  return (
  
      <form onSubmit={submit} className="formulario-general">
        <legend className="legend mt-5">Información del Suscriptor</legend>

        {/* Campo: Usuario */}
        <div className="formulario-campo">
          <label htmlFor="user_id">Usuario</label>
          <select
            className={`select ${errors.user_id && 'border-red-500! text-red-500!'}`}
            name="user_id"
            id="user_id"
            value={data?.user_id ?? ''}
            onChange={(e: React.ChangeEvent<HTMLSelectElement>) => setData('user_id', e.target.value)}
          >
            <option value="">--Seleccione--</option>
            {options?.usuarios?.map((usuario) => (
              <option key={usuario.id} value={usuario.id}>{usuario.name}</option>
            ))}
          </select>
          <TransitionMotion active={errors?.user_id}>
            <AlertMessage message={errors?.user_id} />
          </TransitionMotion>
        </div>

        {/* Campo: Canal */}
        <div className="formulario-campo">
          <label htmlFor="canal_notificacion_id">Canal</label>
          <select
            className={`select ${errors.canal_notificacion_id && 'border-red-500! text-red-500!'}`}
            name="canal_notificacion_id"
            id="canal_notificacion_id"
            value={data?.canal_notificacion_id ?? ''}
            onChange={(e: React.ChangeEvent<HTMLSelectElement>) => setData('canal_notificacion_id', e.target.value)}
          >
            <option value="">--Seleccione--</option>
            {options?.canales?.map((canal) => (
              <option key={canal.id} value={canal.id}>{canal.nombre}</option>
            ))}
          </select>
          <TransitionMotion active={errors?.canal_notificacion_id}>
            <AlertMessage message={errors?.canal_notificacion_id} />
          </TransitionMotion>
        </div>


        {/* Botón de envío */}
        <div className="w-1/2 my-5 mx-auto">
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
