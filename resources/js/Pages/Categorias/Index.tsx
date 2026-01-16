import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { CategoriaTable } from "@/app/domains/categoria"
import { Link } from "@inertiajs/react"
import { type Categoria, CategoriaRoutes } from "@/app/domains/categoria"
export default function Index({
  categorias
}:{
  categorias: {data :Categoria[]} // lo extraemos asi porque asi llega desde el resource que hicimos de categoria para enviarlo con los detalles de sus relaciones
}) {
  console.log(categorias)
  return (
    <div className="section">
        <SectionDescription title="Categorias" paragraph="Gestiona Tus Categorias" />
        <CreateButtonSection>
          <CrudButton
           as={Link}
           href={CategoriaRoutes.create()}
           icon="fa-solid fa-tag"
          
          >
          </CrudButton>
        </CreateButtonSection>
        <CategoriaTable data={categorias.data} />
    </div>
  )
}
