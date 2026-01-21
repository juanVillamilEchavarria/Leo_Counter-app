import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription";
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import {MovimientoFijoForm} from "@/app/domains/movimientoFijo";
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo";
import{ useMovimientoFijo }from "@/app/domains/movimientoFijo";
import { type MovimientoFijoFormOptions, type MovimientoFijo } from "@/app/domains/movimientoFijo";
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData";
export default function Edit({
    options,
    data
}: CreateAndEditViewWithOptionsProps<MovimientoFijo, MovimientoFijoFormOptions >) {
    const {form, handleSubmit}= useMovimientoFijo({method: 'put', id: data?.id, data})
  return (
    <div className="section">
        <CreateOrEditDescription
        type="edit"
        model="Movimiento Fijo"
        />
            <CreateOrEditFormSection
            buttonHref={MovimientoFijoRoutes.index()}
            >
                <MovimientoFijoForm {...form} submit={handleSubmit} options={options}  />
            </CreateOrEditFormSection>
    </div>
  )
}
