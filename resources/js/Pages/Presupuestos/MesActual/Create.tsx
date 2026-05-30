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
import PresupuestoMesActualForm from "@/app/domains/presupuestoMesActual/components/PresupuestoMesActualForm"
import usePresupuestoMesActual from "@/app/domains/presupuestoMesActual/hooks/usePresupuestoMesActual"
import { PresupuestoMesActualRoutes } from "@/app/domains/presupuestoMesActual"
import { type PresupuestoMesActualFormOptions } from "@/app/domains/presupuestoMesActual"
export default function Create({
    options
}:{
    options: PresupuestoMesActualFormOptions
}) {
    const {form, handleSubmit}= usePresupuestoMesActual({})
  return (
    <div className="section">
        <CreateOrEditDescription type="create" model="Presupuesto" />
        <CreateOrEditFormSection
        buttonHref={PresupuestoMesActualRoutes.index()}
        >
            <PresupuestoMesActualForm {...form} submit={handleSubmit} options={options} />
        </CreateOrEditFormSection>
    </div>
  )
}
