import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import CuentasForm from "@/app/domains/cuenta/components/CuentasForm"
import Button from "@/app/shared/components/common/Button"
import { Link } from "@inertiajs/react"
import { useCuenta } from "@/app/domains/cuenta"
import { CuentaRoutes } from "@/app/domains/cuenta"
export default function Create() {
    const {form, handleSubmit}= useCuenta({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Cuenta" />
        <CreateOrEditFormSection buttonHref={CuentaRoutes.index()}>
            <CuentasForm {...form} options={{ tipos_cuentas: [], propietarios: []}} submit={handleSubmit} />
        </CreateOrEditFormSection>

    </div>
  )
}
