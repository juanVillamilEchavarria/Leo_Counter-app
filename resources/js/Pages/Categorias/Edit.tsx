import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription"
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection"
import CategoriaForm from "@/app/domains/categoria/components/CategoriaForm"
import useCategoria from "@/app/domains/categoria/hooks/useCategoria"
import {type  CreateAndEditViewWithOptionsProps } from "@/app/shared/types/formData"
import { type Categoria,type CategoriaFormOptions, CategoriaRoutes } from "@/app/domains/categoria"

export default function Edit({
    options,
    data
}: CreateAndEditViewWithOptionsProps<Categoria, CategoriaFormOptions>) {
    const {form, handleSubmit}= useCategoria({method: 'put', id: data?.id, data})
  return (
    <div className="section">
        <CreateOrEditDescription
        type="edit"
        model="Categoria"
        />
            <CreateOrEditFormSection
            buttonHref={CategoriaRoutes.index()}
            >
                <CategoriaForm {...form} submit={handleSubmit} options={options}  />
            </CreateOrEditFormSection>
    </div>
  )
}
