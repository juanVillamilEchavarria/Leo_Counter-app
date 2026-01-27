import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import PresupuestoMesActualForm from "@/app/domains/presupuestoMesActual/components/PresupuestoMesActualForm"
import usePresupuesto from "@/app/domains/presupuestoMesActual/hooks/usePresupuesto"
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
import { type Presupuesto, type PresupuestoMesActualFormOptions, PresupuestoMesActualRoutes } from "@/app/domains/presupuestoMesActual"

export default function Edit({
    options,
    data
}: CreateAndEditViewWithOptionsProps<Presupuesto, PresupuestoMesActualFormOptions>) {
    const { form, handleSubmit } = usePresupuesto({ method: 'put', id: data?.id, data })
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
