import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import CuentaForm from "@/app/domains/cuenta/components/CuentaForm"
import { useCuenta } from "@/app/domains/cuenta"
import { CuentaRoutes } from "@/app/domains/cuenta"
import { type Cuenta, type CuentaFormOptions, type CuentaEditViewProps} from "@/app/domains/cuenta"
import {type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
export default function Edit({
    options,
    data,
    can_update_saldo
}:CuentaEditViewProps) {
   const {form, handleSubmit}= useCuenta({method: 'put', id: data?.id, data})
   console.log(can_update_saldo);
   
    return (
      <div className="section">
          <CreateOrEditDescription type="edit" model="Cuenta" />
          <CreateOrEditFormSection buttonHref={CuentaRoutes.index()}>
              <CuentaForm {...form} options={options} submit={handleSubmit} can_update_saldo={can_update_saldo} />
          </CreateOrEditFormSection>
  
      </div>
    )
}
