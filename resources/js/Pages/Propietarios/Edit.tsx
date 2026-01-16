import CreateOrEditDescription from "@/app/shared/components/common/CreateOrEditDescription";
import CreateOrEditFormSection from "@/app/shared/components/common/CreateOrEditFormSection";
import PropietarioForm from "@/app/domains/propietario/components/PropietarioForm";
import usePropietario from "@/app/domains/propietario/hooks/usePropietario";
import { type Propietario , PropietarioRoutes} from "@/app/domains/propietario"
export default function Edit({
    title, data
}:{
    title: string,
    data: Propietario
}) {
    const {form, handleSubmit}= usePropietario({method: 'put', id: data?.id, data})
    console.log(data);
  return (
    <div className="section">
        <CreateOrEditDescription type="edit" model="Propietario" />
        <CreateOrEditFormSection buttonHref={PropietarioRoutes.index()}>
            <PropietarioForm {...form} submit={handleSubmit}  />
        </CreateOrEditFormSection>
    </div>
  )
}
