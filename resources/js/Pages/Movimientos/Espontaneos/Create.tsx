import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import { MovimientoEspontaneoForm, useMovimientoEspontaneo, MovimientoEspontaneoRoutes } from "@/app/domains/movimientoEspontaneo"
import { type MovimientoFijoFormOptions } from "@/app/domains/movimientoFijo"

export default function Create({
     options
}:{
    options: MovimientoFijoFormOptions
}) {
    const {form, handleSubmit}= useMovimientoEspontaneo({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Movimiento Espontaneo" />
        <CreateOrEditFormSection
        buttonHref={MovimientoEspontaneoRoutes.index()}
        >
            <MovimientoEspontaneoForm {...form} submit={handleSubmit} options={options} />
        </CreateOrEditFormSection>
    </div>
  )
}
