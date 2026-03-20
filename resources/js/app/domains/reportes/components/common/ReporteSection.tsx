import SectionTransition from "@/app/shared/components/common/SectionTransition"
import ReporteSheet from "../Sheet/ReporteSheet"
import Title from "@/app/shared/components/common/Title"
import { type SetActiveReportFilters } from "../../hooks/Charts/useActiveReportFilters"
import { type ReporteSheetProps } from "../Sheet/ReporteSheet"

interface ReporteSectionProps extends ReporteSheetProps {
  children: React.ReactNode
  setActiveReportFilters: SetActiveReportFilters
}

export default function ReporteSection({
  setData,
  setIsLoading,
  setError,
  children,
  setActiveReportFilters,
}: ReporteSectionProps) {
  return (
    <SectionTransition>
      <div className="flex w-full justify-between mb-5">
        <div className="flex flex-col gap-2">
          <Title title="Reportes" size="3xl" />
          <p>Genera y analiza tus reportes financieros</p>
        </div>
        <ReporteSheet setActiveReportFilters={setActiveReportFilters} setData={setData} setError={setError} setIsLoading={setIsLoading} />
      </div>

      <div className="flex flex-col gap-4">
        {children}
      </div>
    </SectionTransition>
  )
}
