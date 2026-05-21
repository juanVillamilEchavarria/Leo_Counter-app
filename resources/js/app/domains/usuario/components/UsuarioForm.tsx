import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { useMessageRedirect } from "@/app/shared/hooks"
import useUsuario from "../hooks/useUsuario"
import { type UsuarioData } from "../types/usuario.types"

interface UsuarioFormProps {
  data?: UsuarioData
}

export default function UsuarioForm({ data }: UsuarioFormProps) {
      const { props } = useMessageRedirect()
      const usuario = data ?? props.auth?.user
      const { form, handleSubmit } = useUsuario({
        data: usuario,
        action: 'updateDatosPublicos'
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
                />
                <TransitionMotion active={form.errors.email} initial={{opacity:0, y: -20}}>
                    <AlertMessage type="error" message={form.errors.email} />
                </TransitionMotion>
            </div>
            <div className="w-[20%] mt-5 mx-auto">
                <Button variant="secondary" type="submit">Guardar</Button>
            </div>
        </form>
    </Card>
  )
}
