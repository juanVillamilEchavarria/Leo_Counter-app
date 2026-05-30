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
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
import { type Presupuesto, type PresupuestoMesActualFormOptions, PresupuestoMesActualRoutes } from "@/app/domains/presupuestoMesActual"

export default function Edit({
    options,
    data
}: CreateAndEditViewWithOptionsProps<Presupuesto, PresupuestoMesActualFormOptions>) {
    console.log(data);
    const { form, handleSubmit } = usePresupuestoMesActual({ method: 'put', id: data?.id, data })
    return (
        <div className="section">
            <CreateOrEditDescription
                type="edit"
                model="Presupuesto"
            />
            <CreateOrEditFormSection
                buttonHref={PresupuestoMesActualRoutes.index()}
            >
                <PresupuestoMesActualForm {...form} submit={handleSubmit} options={options} />
            </CreateOrEditFormSection>
        </div>
    )
}
