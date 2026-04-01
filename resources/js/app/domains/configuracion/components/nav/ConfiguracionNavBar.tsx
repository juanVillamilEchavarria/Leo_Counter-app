import SectionNavBar from "@/app/shared/components/common/SectionNavBar"
import { ConfiguracionNavItems } from "../../types/configuracion.types"
/**
 * Barra de navegacion para la seccion de configuracion
 * @returns {JSX.Element}
 */
export default function ConfiguracionNavBar() {
  return (
    <div className="mt-10">
      <SectionNavBar navItems={ConfiguracionNavItems} className="w-full!" />
    </div>
  )
}
