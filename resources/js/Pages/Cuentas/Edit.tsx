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
   
    return (
      <div className="section">
          <CreateOrEditDescription type="edit" model="Cuenta" />
          <CreateOrEditFormSection buttonHref={CuentaRoutes.index()}>
              <CuentaForm {...form} options={options} submit={handleSubmit} can_update_saldo={can_update_saldo} />
          </CreateOrEditFormSection>
  
      </div>
    )
}
