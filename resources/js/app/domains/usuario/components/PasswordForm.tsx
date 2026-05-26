import Card from "@/app/shared/components/common/Card"
import InputFillable from "@/app/shared/components/form/InputFillable"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import useChangePassword from "../hooks/useChangePassword"

export default function PasswordForm() {
  const { form, handleSubmit } = useChangePassword({
    data: {
        current_password: '',
        password: '',
        password_confirmation: ''
    }
  });

  return (
     <Card>
         <form className="formulario-general" onSubmit={handleSubmit}>
                <div className="formulario-campo">
                    <label htmlFor="current_password">Contraseña actual</label>
                    <InputFillable
                    type="password"
                    name="current_password"
                    id="current_password"
                    placeholder="Mi Contraseña Actual"
                    value={form.data?.current_password}
                    onChange={(e)=>form.setData('current_password', e.target.value)}/>
                    <TransitionMotion active={form.errors.current_password} initial={{opacity:0, y: -20}}>
                        <AlertMessage type="error" message={form.errors.current_password} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="password">Contraseña Nueva</label>
                    <InputFillable
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Mi Contraseña Nueva"
                    value={form.data?.password}
                    onChange={(e)=>form.setData('password', e.target.value)}/>
                    <TransitionMotion active={form.errors.password} initial={{opacity:0, y: -20}}>
                        <AlertMessage type="error" message={form.errors.password} />
                    </TransitionMotion>
                </div>
                <div className="formulario-campo">
                    <label htmlFor="password_confirmation">Repetir Contraseña</label>
                    <InputFillable
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Mi Contraseña Nueva"
                    value={form.data?.password_confirmation}
                    onChange={(e)=>form.setData('password_confirmation', e.target.value)}/>
                    <TransitionMotion active={form.errors.password_confirmation} initial={{opacity:0, y: -20}}>
                        <AlertMessage type="error" message={form.errors.password_confirmation} />
                    </TransitionMotion>
                </div>
                <div className="w-[20%] mt-5 mx-auto">
                    <Button variant="secondary" type="submit">Guardar</Button>
                </div>
            </form>
     </Card>
  )
}
