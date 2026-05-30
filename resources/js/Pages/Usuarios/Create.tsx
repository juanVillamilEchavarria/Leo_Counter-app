/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import UsuarioAdminForm from "@/app/domains/usuario/components/UsuarioAdminForm"
import { useUsuario, UsuarioRoutes } from "@/app/domains/usuario"

/**
 * Página de creación de un nuevo usuario en el módulo de administración.
 * Renderiza el formulario de creación con campos de nombre, email, contraseña y confirmación.
 */
export default function Create() {
    const { form, handleSubmit } = useUsuario({})

    return (
        <div className="section">
            <CreateOrEditDescription type="create" model="Usuario" />
            <CreateOrEditFormSection buttonHref={UsuarioRoutes.index()}>
                <UsuarioAdminForm
                    {...form}
                    submit={handleSubmit}
                    isCreate={true}
                />
            </CreateOrEditFormSection>
        </div>
    )
}
