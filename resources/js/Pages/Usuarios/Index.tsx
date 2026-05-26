import SectionDescription from "@/app/shared/components/common/SectionDescription"
import UsuarioTable from "@/app/domains/usuario/components/UsuarioTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import { Link } from "@inertiajs/react"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { UsuarioRoutes } from "@/app/domains/usuario"
import { useModalItem } from "@/app/shared/hooks"
import useUsuario from "@/app/domains/usuario/hooks/useUsuario"
import { type Usuario } from "@/app/domains/usuario"

/**
 * Página de listado de usuarios en el módulo de administración.
 * Muestra la tabla de usuarios con acciones de crear, editar y eliminar.
 * @param usuarios - Colección de usuarios proporcionada por el backend.
 */
export default function Index({
  usuarios
}: {
  usuarios: Usuario[]
}) {
  const { item, modal, open, close, setItem } = useModalItem<Usuario>()
  const { handleSubmit } = useUsuario({ method: 'delete', id: item?.id })

  return (
    <SectionTransition>
        <SectionDescription title="Usuarios" paragraph="Administra los usuarios del sistema" />
        <CreateButtonSection>
            <CrudButton
                as={Link}
                href={UsuarioRoutes.create()}
                icon="fa-solid fa-user-plus"
            />
        </CreateButtonSection>

        <div className="overflow-scroll scrollbar-modern">
            <UsuarioTable data={usuarios} onSelect={(item, modalType) => open(item, modalType)} />
        </div>

        <DeleteModal
            open={item !== null && modal === 'delete'}
            onClose={close}
            onSubmit={(e) => { handleSubmit(e); setItem(null) }}
            title={' Usuario'}
            paragraph={`¿Está seguro de eliminar al usuario: ${item?.name} ?`}
        />
    </SectionTransition>
  )
}
