/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { ProfileNavItems } from "../types/usuario.types"
import SectionNavBar from "@/app/shared/components/common/SectionNavBar"

export default function UsuarioNavBar() {
  return (
    <div className="mt-10">
      <SectionNavBar navItems={ProfileNavItems} />
    </div>
  )
}
