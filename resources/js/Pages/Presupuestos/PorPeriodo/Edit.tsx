import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import PresupuestoPorPeriodoForm from "@/app/domains/presupuestoPorPeriodo/components/PresupuestoPorPeriodoForm"
import usePresupuestoPorPeriodo from "@/app/domains/presupuestoPorPeriodo/hooks/usePresupuestoPorPeriodo"
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
import { type PresupuestoPorPeriodo, type PresupuestoPorPeriodoFormOptions, PresupuestoPorPeriodoRoutes } from "@/app/domains/presupuestoPorPeriodo"

export default function Edit({
    options,
    data
}: CreateAndEditViewWithOptionsProps<PresupuestoPorPeriodo, PresupuestoPorPeriodoFormOptions>) {
    const { form, handleSubmit } = usePresupuestoPorPeriodo({ method: 'put', id: data?.id, data })
    return (
        <div className="section">
            <CreateOrEditDescription
                type="edit"
                model="Presupuesto Por Período"
            />
            <CreateOrEditFormSection
                buttonHref={PresupuestoPorPeriodoRoutes.index()}
            >
                <PresupuestoPorPeriodoForm {...form} submit={handleSubmit} options={options} />
            </CreateOrEditFormSection>
        </div>
    )
}
