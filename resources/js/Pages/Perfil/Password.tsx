import UsuarioNavBar from "@/app/domains/usuario/components/UsuarioNavBar"
import Title from "@/app/shared/components/common/Title"
import PasswordForm from "@/app/domains/usuario/components/PasswordForm"
import SectionTransition from "@/app/shared/components/common/SectionTransition"

export default function Password() {
  return (
    <SectionTransition>
        <UsuarioNavBar />
        <div className="w-[50%] mx-auto mt-10 flex flex-col justify-center">
            <div className="flex flex-col text-foreground gap-5">
                <Title
                title={
                    <div>
                        <i className="fa-solid fa-fingerprint"></i>
                        <span>Mi Contraseña</span>
                    </div>
                    }
                size="5xl"
                 />
                <p>Aqui puedes actualizar tu contraseña</p>
            </div>

            <div className="mt-10">
                <PasswordForm />
            </div>
        </div>
     </SectionTransition>
  )
}
