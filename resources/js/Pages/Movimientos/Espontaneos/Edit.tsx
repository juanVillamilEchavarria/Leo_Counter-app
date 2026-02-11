import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription";
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection";
import {useMovimientoEspontaneo, MovimientoEspontaneoForm, MovimientoEspontaneoRoutes} from "@/app/domains/movimientoEspontaneo"
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types"
import { type MovimientoFijoFormOptions } from "@/app/domains/movimientoFijo"
import { type MovimientoEspontaneo } from "@/app/domains/movimientoEspontaneo"
export default function Edit({
  data,
  options
}:{
  data? : {data: MovimientoEspontaneo}
  options: MovimientoFijoFormOptions
}) {
  const {form, handleSubmit}= useMovimientoEspontaneo({method: 'put', id: data?.data.id, data: data?.data})
  return (
    <div className="section">
        <CreateOrEditDescription
        type="edit"
        model="Movimiento Espontaneo"
        />
            <CreateOrEditFormSection
            buttonHref={MovimientoEspontaneoRoutes.index()}
            >
                <MovimientoEspontaneoForm {...form} submit={handleSubmit} options={options}  />
            </CreateOrEditFormSection>
    </div>
  )
}
