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
import { useMessageRedirect } from "@/app/shared/hooks"
import { type UsuarioData } from "../types/usuario.types"
import useProfile from "../hooks/useProfile"

interface UsuarioFormProps {
  data: UsuarioData
}

export default function UsuarioForm({ data }: UsuarioFormProps) {
      const { props } = useMessageRedirect()
      const { form, handleSubmit } = useProfile({
        data: data,
      });

  return (
    <Card>
        <form onSubmit={handleSubmit} className="formulario-general">
            <div className="formulario-campo">
                <label htmlFor="name">Nombre</label>
                <InputFillable
                type="text"
                 name="name"
                 id="name"
                 placeholder="Mi Nombre"
                  value={form.data.name} onChange={(e)=>form.setData('name', e.target.value)}/>
                <TransitionMotion active={form.errors.name} initial={{opacity:0, y: -20}}>
                    <AlertMessage type="error" message={form.errors.name} />
                </TransitionMotion>
            </div>
            <div className="formulario-campo">
                <label htmlFor="email">E-mail</label>
                <InputFillable
                type="text"
                 name="email"
                 id="email"
                 placeholder="Mi E-mail"
                 value={form.data.email}
                 onChange={(e)=>form.setData('email', e.target.value)}
                disabled={form.data.isSuscribed}
                className={`${form.data.isSuscribed ? 'bg-muted cursor-not-allowed' : ''}`}
                icon={form.data.isSuscribed ? 'fa-solid fa-lock text-2xl' : ''}
                />
                <TransitionMotion active={form.errors.email} initial={{opacity:0, y: -20}}>
                    <AlertMessage type="error" message={form.errors.email} />
                </TransitionMotion>

                {form.data.isSuscribed && (
                    <p className="text-red-400 dark:text-red-200 mt-2 text-xs">No puedes actualizar este campo, ya que estas suscrito a un canal de notificacion que lo implementa, si quieres actualizarlo, dile al administrador que te quite de la lista de suscritos a notificaciones</p>
                )}
            </div>
            <div className="w-full mt-5 mx-auto sm:w-1/2 lg:w-[20%]">
                <Button variant="secondary" type="submit">Guardar</Button>
            </div>
        </form>
    </Card>
  )
}
