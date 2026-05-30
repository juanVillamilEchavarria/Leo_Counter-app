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
import PropietarioForm from "@/app/domains/propietario/components/PropietarioForm"
import usePropietario from "@/app/domains/propietario/hooks/usePropietario"
import { PropietarioRoutes } from "@/app/domains/propietario"

export default function Create() {
  const {form, handleSubmit}= usePropietario({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Propietario" />
        <CreateOrEditFormSection
        buttonHref={PropietarioRoutes.index()}
         >
            <PropietarioForm {...form} submit={handleSubmit}  />
        </CreateOrEditFormSection>
    </div>
  )
}
