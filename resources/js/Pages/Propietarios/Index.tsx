import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import { PropietarioTable } from "@/app/domains/propietario"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { Link } from "@inertiajs/react"
import { type Propietario } from "@/app/domains/propietario"
export default function Index({
  propietarios
}:{
  propietarios: Propietario[]
}) {
  console.log(propietarios)
  return (
    <div className="section">
        <SectionDescription title="Propietarios" paragraph="Gestiona Tus Propietarios" />
        <CreateButtonSection>
          <CrudButton
            as={Link}
            href="#"
            icon="fa-solid fa-users"
            />
        </CreateButtonSection>
        <PropietarioTable
        data={propietarios}
         />
    </div>
  )
}
