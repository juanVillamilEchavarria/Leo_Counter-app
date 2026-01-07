import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { CategoriaTable } from "@/app/domains/categoria"
import { Link } from "@inertiajs/react"
export default function Index() {
  return (
    <div className="section">
        <SectionDescription title="Categorias" paragraph="Gestiona Tus Categorias" />
        <CreateButtonSection>
          <CrudButton
           as={Link}
           href="#"
           icon="fa-solid fa-tag"
          
          >
          </CrudButton>
        </CreateButtonSection>
        <CategoriaTable />
    </div>
  )
}
