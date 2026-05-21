import { UsuarioNavItems } from "../types/usuario.types"
import SectionNavBar from "@/app/shared/components/common/SectionNavBar"

export default function UsuarioNavBar() {
  return (
    <div className="mt-10">
      <SectionNavBar navItems={UsuarioNavItems} />
    </div>
  )
}
