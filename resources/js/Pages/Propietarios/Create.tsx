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
