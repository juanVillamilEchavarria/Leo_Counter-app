/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import UsuarioAdminForm from "@/app/domains/usuario/components/UsuarioAdminForm"
import UsuarioChangePasswordForm from "@/app/domains/usuario/components/UsuarioChangePasswordForm"
import { useUsuario, UsuarioRoutes, type Usuario } from "@/app/domains/usuario"
import useUsuarioChangePassword from "@/app/domains/usuario/hooks/useUsuarioChangePassword"
import { Link } from "@inertiajs/react"
import Button from "@/app/shared/components/common/Button"

/**
 * Página de edición de un usuario en el módulo de administración.
 * Incluye el formulario de edición de datos públicos (nombre, email) y
 * un formulario separado para cambiar la contraseña del usuario.
 * @param data - Datos del usuario a editar (id, name, email, isSuscribed).
 */
export default function Edit({
    data,
}: {
    data: Usuario
}) {
    const { form, handleSubmit } = useUsuario({ method: 'put', id: data?.id, data })
    const { form: passwordForm, handleSubmit: handlePasswordSubmit } = useUsuarioChangePassword({
        id: data.id
    })

    return (
        <div className="section">
            <CreateOrEditDescription type="edit" model="Usuario" />
            <div className="w-3/4 mx-auto mt-10">
                 <Button
                    as={Link} 
                    variant="primaryPagination" 
                    className="rounded-lg! text-xl" 
                    href={UsuarioRoutes.index()}
                    >
                    <i className="fa-solid fa-arrow-left"></i>
                </Button>
                <div className=" flex gap-3 ">
                    <UsuarioAdminForm
                    {...form}
                    submit={handleSubmit}
                    isSuscribed={data.isSuscribed}
                    />
                {/* Sección de cambio de contraseña */}
                        <UsuarioChangePasswordForm
                            {...passwordForm}
                            submit={handlePasswordSubmit}
                        />

                </div>
            </div>
            
            

        </div >
    )
}
