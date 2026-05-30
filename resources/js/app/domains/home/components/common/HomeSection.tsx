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
export default function HomeSection({
    children
}:{
    children : React.ReactNode
}) {
  return (
    <SectionTransition>
            <SectionDescription title="Home" paragraph="Un resumen de tus reportes y estadisticas de este mes" />
            {children}
        </SectionTransition>
  )
}
