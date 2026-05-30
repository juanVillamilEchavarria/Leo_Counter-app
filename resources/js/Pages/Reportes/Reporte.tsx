/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import ReporteSection from "@/app/domains/reportes/components/common/ReporteSection"
import ActiveReportFilters from "@/app/domains/reportes/components/Filters/ActiveReportFilters"
import DownloadReportButton from "@/app/domains/reportes/components/common/DownloadReportButton"
import { useReporteApi, KPISection, ChartSection, ReporteDataSectionId } from "@/app/domains/reportes"
import useReporteApiData from "@/app/domains/reportes/hooks/utilities/useReporteApiData"
import { useEffect } from "react"
import useActiveReportFilters from "@/app/domains/reportes/hooks/Charts/useActiveReportFilters"
import { useResetActiveFilters } from "@/app/domains/reportes/hooks/utilities/useResetActiveFilters"
export default function Reporte() {
  const { data: initialData, isLoading: initialIsLoading, error: initialError } = useReporteApi()
  const { data, setData, isLoading, setIsLoading, error, setError } = useReporteApiData({
    initialData,
    initialIsLoading,
    initialError
  })
  useEffect(() => {
    setIsLoading(initialIsLoading)
    setError(initialError)
    if (initialData) {
      setData(initialData)
    }
  }, [initialIsLoading, initialError, initialData, setIsLoading, setError, setData])

  const activeFilters = useActiveReportFilters()
  const { reset: resetFilters, isResetting } = useResetActiveFilters({
    setData,
    setIsLoading,
    setError,
    setActiveReportFilters: {
      setPeriodo: activeFilters.setPeriodo,
      setCategorias: activeFilters.setCategorias,
      setCuentas: activeFilters.setCuentas,
      reset: activeFilters.reset
    }
  })


  if (isLoading) {
    return (
      <ReporteSection
        setData={setData}
        setIsLoading={setIsLoading}
        setError={setError}
        setActiveReportFilters={{
          setPeriodo: activeFilters.setPeriodo,
          setCategorias: activeFilters.setCategorias,
          setCuentas: activeFilters.setCuentas,
          reset: activeFilters.reset
        }}
        
      >
        <div className="flex flex-col items-center justify-center min-h-100 space-y-4">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-foreground">Cargando reportes financieros</h3>
            <p className="text-sm text-muted-foreground">Estamos procesando tus datos para generar los análisis más precisos</p>
          </div>
        </div>
      </ReporteSection>
    )
  }

  if (error) {
    return (
      <ReporteSection
        setData={setData}
        setIsLoading={setIsLoading}
        setError={setError}
        setActiveReportFilters={{
          setPeriodo: activeFilters.setPeriodo,
          setCategorias: activeFilters.setCategorias,
          setCuentas: activeFilters.setCuentas,
          reset: activeFilters.reset
        }}
        
      >
        <div className="flex flex-col items-center justify-center min-h-100 space-y-4">
          <div className="text-red-500">
            <i className="fa-solid fa-exclamation-triangle text-4xl"></i>
          </div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-foreground">Error al cargar los reportes</h3>
            <p className="text-sm text-muted-foreground">No pudimos cargar tus datos financieros en este momento</p>
            <button
              onClick={() => window.location.reload()}
              className="mt-4 px-4 py-2 bg-blue-600 text-primary-foreground rounded-lg hover:bg-blue-700 transition-colors"
            >
              Intentar nuevamente
            </button>
          </div>
        </div>
      </ReporteSection>
    )
  }

  if (!data?.data) {
    return (
      <ReporteSection
        setData={setData}
        setIsLoading={setIsLoading}
        setError={setError}
        setActiveReportFilters={{
          setPeriodo: activeFilters.setPeriodo,
          setCategorias: activeFilters.setCategorias,
          setCuentas: activeFilters.setCuentas,
          reset: activeFilters.reset
        }}
        
      >
        <div className="flex flex-col items-center justify-center min-h-100 space-y-4">
          <div className="text-muted-foreground">
            <i className="fa-solid fa-chart-line text-4xl"></i>
          </div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-foreground">No hay datos disponibles</h3>
            <p className="text-sm text-muted-foreground">Aún no tienes movimientos registrados para generar reportes</p>
          </div>
        </div>
      </ReporteSection>
    )
  }

  const { KPIs, tendencia, distribuiciones } = data.data

  return (
    <ReporteSection
      setData={setData}
      setIsLoading={setIsLoading}
      setError={setError}
      setActiveReportFilters={{
        setPeriodo: activeFilters.setPeriodo,
        setCategorias: activeFilters.setCategorias,
        setCuentas: activeFilters.setCuentas,
        reset: activeFilters.reset
      }}
      
    >
      <ActiveReportFilters
        periodo={activeFilters.periodo}
        categorias={activeFilters.categorias}
        cuentas={activeFilters.cuentas}
        onReset={resetFilters}
        isResetting={isResetting}
      />
      <DownloadReportButton/>
      <div className="" id={ReporteDataSectionId}>
        <KPISection kpis={KPIs} />
        <ChartSection tendencia={tendencia} distribuciones={distribuiciones} />
      </div>
    </ReporteSection>
  )
}
