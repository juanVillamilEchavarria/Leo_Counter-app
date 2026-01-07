import SectionDescription from "@/app/shared/components/common/SectionDescription"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { Link } from "@inertiajs/react"
export default function Index() {
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
    </div>
  )
}
