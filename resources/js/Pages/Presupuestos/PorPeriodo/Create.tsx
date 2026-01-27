import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import PresupuestoPorPeriodoForm from "@/app/domains/presupuestoPorPeriodo/components/PresupuestoPorPeriodoForm"
import usePresupuestoPorPeriodo from "@/app/domains/presupuestoPorPeriodo/hooks/usePresupuestoPorPeriodo"
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
import { type PresupuestoPorPeriodo, type PresupuestoPorPeriodoFormOptions, PresupuestoPorPeriodoRoutes } from "@/app/domains/presupuestoPorPeriodo"

export default function Create({
    options
}: CreateAndEditViewWithOptionsProps<PresupuestoPorPeriodo, PresupuestoPorPeriodoFormOptions>) {
    const { form, handleSubmit } = usePresupuestoPorPeriodo({ method: 'post' })
    return (
        <div className="section">
            <CreateOrEditDescription
                type="create"
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
