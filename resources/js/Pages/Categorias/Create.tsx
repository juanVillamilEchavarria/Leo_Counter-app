import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import CategoriaForm from "@/app/domains/categoria/components/CategoriaForm"
import useCategoria from "@/app/domains/categoria/hooks/useCategoria"
import { type CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
import { type Categoria, type CategoriaFormOptions } from "@/app/domains/categoria"
import { CategoriaRoutes } from "@/app/domains/categoria"
export default function Create({
    options
}:CreateAndEditViewWithOptionsProps<Categoria, CategoriaFormOptions>) {
    const {form, handleSubmit}= useCategoria({})
  return (
    <div className="section">
        <CreateOrEditDescription
        type="create"
        model="Categoria"
        />
            <CreateOrEditFormSection
            buttonHref={CategoriaRoutes.index()}
            >
                <CategoriaForm {...form} submit={handleSubmit} options={options} />
            </CreateOrEditFormSection>
    </div>
  )
}
