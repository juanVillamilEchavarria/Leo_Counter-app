/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import { HistorialTable } from "@/app/domains/historial"
export default function Historial() {
  return (
    <SectionTransition>
        <SectionDescription title="Historial" paragraph="Mira Quien Cambio Que" />
        <HistorialTable />
        
    </SectionTransition>
  )
}
