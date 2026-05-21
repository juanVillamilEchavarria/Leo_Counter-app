import Title from "@/app/shared/components/common/Title"
import UsuarioNavBar from "@/app/domains/usuario/components/UsuarioNavBar"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { UsuarioForm, type UsuarioData } from "@/app/domains/usuario"

interface PerfilProps {
  data?: UsuarioData
}

export default function Perfil({ data }: PerfilProps) {
  return (
    <SectionTransition>
        <UsuarioNavBar />
        <div className="w-[50%] mx-auto mt-10 flex flex-col justify-center">
            <div className="flex flex-col text-foreground gap-5">
                <Title
                title={
                    <div>
                        <i className="fa-solid fa-child-reaching"></i>
                        <span>Mi Usuario</span>
                    </div>
                    }
                size="5xl"
                 />
                <p>Aqui puedes actualizar tu informacion</p>
            </div>

            <div className="mt-10">
                <UsuarioForm data={data} />
            </div>
        </div>
     </SectionTransition>
  )
}
