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
