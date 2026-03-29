import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription";
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import {MovimientoFijoForm} from "@/app/domains/movimientoFijo";
import { MovimientoFijoRoutes } from "@/app/domains/movimientoFijo";
import{ useMovimientoFijo }from "@/app/domains/movimientoFijo";
import { type MovimientoFijoFormOptions } from "@/app/domains/movimientoFijo";
export default function Create({
    options
}:{
    options: MovimientoFijoFormOptions
}) {

    const {form, handleSubmit}= useMovimientoFijo({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Movimiento Fijo" />
        <CreateOrEditFormSection
        buttonHref={MovimientoFijoRoutes.index()}
        >
            <MovimientoFijoForm {...form} submit={handleSubmit} options={options} />
        </CreateOrEditFormSection>
    </div>
  )
}
