import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import CuentaForm from "@/app/domains/cuenta/components/CuentaForm"
import { useCuenta } from "@/app/domains/cuenta"
import { CuentaRoutes } from "@/app/domains/cuenta"
import { type Cuenta, type CuentaFormOptions} from "@/app/domains/cuenta"

import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
export default function Create({
  options
}:CreateAndEditViewWithOptionsProps<Cuenta, CuentaFormOptions> 
) {
    const {form, handleSubmit}= useCuenta({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Cuenta" />
        <CreateOrEditFormSection buttonHref={CuentaRoutes.index()}>
            <CuentaForm {...form} options={options} submit={handleSubmit} />
        </CreateOrEditFormSection>

    </div>
  )
}
