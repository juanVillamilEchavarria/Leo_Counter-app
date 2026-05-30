/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import Title from "@/app/shared/components/common/Title"
import UsuarioNavBar from "@/app/domains/usuario/components/UsuarioNavBar"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { UsuarioForm, type UsuarioData } from "@/app/domains/usuario"

interface PerfilProps {
  data: UsuarioData
}

export default function Perfil({ data }: PerfilProps) {
  return (
    <SectionTransition>
        <UsuarioNavBar />
        <div className="w-full px-4 sm:px-6 lg:w-[50%] lg:px-0 mx-auto mt-10 flex flex-col justify-center">
            <div className="flex flex-col text-foreground gap-5">
                <Title
                title={
                    <div>
                        <i className="fa-solid fa-child-reaching"></i>
                        <span>Mi Perfil</span>
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
