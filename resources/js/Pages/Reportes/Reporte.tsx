import SectionTransition from "@/app/shared/components/common/SectionTransition"
import Title from "@/app/shared/components/common/Title"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import { useOpen } from "@/app/shared/hooks"
import { ReporteSheet, useReporteApi, KPISection, ChartSection } from "@/app/domains/reportes"

export default function Reporte() {
  const { isOpen, setIsOpen } = useOpen(false)
  const { isOpen: isOpenCuentas, setIsOpen: setIsOpenCuentas } = useOpen(false)
  const { data, isLoading, error } = useReporteApi()

  if (isLoading) {
    return (
      <SectionTransition>
        <div className="flex w-full justify-between mb-5">
          <div className="flex flex-col gap-2">
            <Title title="Reportes" size="3xl" />
            <p>Genera y analiza tus reportes financieros</p>
          </div>
          <ReporteSheet />
        </div>
        <div className="flex flex-col items-center justify-center min-h-[400px] space-y-4">
          <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-gray-900">Cargando reportes financieros</h3>
            <p className="text-sm teflex w-full justify-between mb-5xt-gray-500">Estamos procesando tus datos para generar los análisis más precisos</p>
          </div>
        </div>
      </SectionTransition>
    )
  }

  if (error) {
    return (
      <SectionTransition>
        <div className="flex w-full justify-between mb-5">
          <div className="flex flex-col gap-2">
            <Title title="Reportes" size="3xl" />
            <p>Genera y analiza tus reportes financieros</p>
          </div>
          <ReporteSheet />
        </div>
        <div className="flex flex-col items-center justify-center min-h-[400px] space-y-4">
          <div className="text-red-500">
            <i className="fa-solid fa-exclamation-triangle text-4xl"></i>
          </div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-gray-900">Error al cargar los reportes</h3>
            <p className="text-sm text-gray-500">No pudimos cargar tus datos financieros en este momento</p>
            <button
              onClick={() => window.location.reload()}
              className="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              Intentar nuevamente
            </button>
          </div>
        </div>
      </SectionTransition>
    )
  }

  if (!data?.data) {
    return (
      <SectionTransition>
        <div className="flex w-full justify-between mb-5">
          <div className="flex flex-col gap-2">
            <Title title="Reportes" size="3xl" />
            <p>Genera y analiza tus reportes financieros</p>
          </div>
          <ReporteSheet />
        </div>
        <div className="flex flex-col items-center justify-center min-h-[400px] space-y-4">
          <div className="text-gray-400">
            <i className="fa-solid fa-chart-line text-4xl"></i>
          </div>
          <div className="text-center space-y-2">
            <h3 className="text-lg font-semibold text-gray-900">No hay datos disponibles</h3>
            <p className="text-sm text-gray-500">Aún no tienes movimientos registrados para generar reportes</p>
          </div>
        </div>
      </SectionTransition>
    )
  }

  const { KPIs, tendencia, distribuiciones } = data.data

  return (
    <SectionTransition>
      <div className="flex w-full justify-between mb-5">
        <div className="flex flex-col gap-2">
          <Title title="Reportes" size="3xl" />
          <p>Genera y analiza tus reportes financieros</p>
        </div>
        <ReporteSheet />
      </div>

      <div className="bg-white rounded-lg border border-gray-200 p-4 mb-6">
        <h4 className="font-semibold text-gray-900 mb-3">Filtros activos</h4>
        <ul className="space-y-2">
          <li className="flex items-center gap-2 text-sm text-gray-600">
            <i className="fa-solid fa-calendar text-blue-500"></i>
            <span>Últimos 6 meses</span>
          </li>
          <li>
            <button
              type="button"
              className="flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600 transition-colors"
              onClick={() => setIsOpen(prev => !prev)}
            >
              <i className="fa-solid fa-tag text-orange-500"></i>
              <span>3 Categorías seleccionadas</span>
              <i className={`fa-solid fa-chevron-${isOpen ? 'up' : 'down'} transition-transform`}></i>
            </button>
            <TransitionMotion active={isOpen} initial={{ x: 0, y: -10, opacity: 0 }} exit={{ x: 0, y: -10, opacity: 0 }}>
              <ul className="ml-6 mt-2 space-y-1 text-xs text-gray-500">
                <li>• Ingresos laborales</li>
                <li>• Compras</li>
                <li>• Alquileres</li>
              </ul>
            </TransitionMotion>
          </li>
          <li>
            <button
              type="button"
              className="flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600 transition-colors"
              onClick={() => setIsOpenCuentas(prev => !prev)}
            >
              <i className="fa-solid fa-wallet text-green-500"></i>
              <span>3 Cuentas seleccionadas</span>
              <i className={`fa-solid fa-chevron-${isOpenCuentas ? 'up' : 'down'} transition-transform`}></i>
            </button>
            <TransitionMotion active={isOpenCuentas} initial={{ x: 0, y: -10, opacity: 0 }} exit={{ x: 0, y: -10, opacity: 0 }}>
              <ul className="ml-6 mt-2 space-y-1 text-xs text-gray-500">
                <li>• Cuenta Mamá</li>
                <li>• Cuenta Juanes</li>
                <li>• Cuenta Maria</li>
              </ul>
            </TransitionMotion>
          </li>
        </ul>
      </div>

      <KPISection kpis={KPIs} />

      <ChartSection tendencia={tendencia} distribuciones={distribuiciones} />
    </SectionTransition>
  )
}
