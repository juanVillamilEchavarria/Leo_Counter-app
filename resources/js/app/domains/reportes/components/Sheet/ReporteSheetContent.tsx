import { SheetContent, SheetClose, SheetDescription, SheetHeader, SheetTitle, SheetFooter } from "@/app/shared/components/ui/sheet"
import ReporteForm from "./ReporteForm"
import useReporteFormOptionsApi from "../../hooks/api/useReporteFormOptionsApi"
import { useReporteForm } from "../../hooks/Form/useReporteForm"
import { useGenerateReportMutation } from "../../hooks/api/useGenerateReportMutation"
import { useCallback, useEffect } from "react"
import { type ReporteSheetProps } from "./ReporteSheet"
import { formatActiveFilters } from "../../helpers/formatActiveFilters"
import { toastHelper } from "@/app/shared/helpers"
export default function ReporteSheetContent({
  setData,
  setIsLoading,
  setError,
  setActiveReportFilters
}: ReporteSheetProps) {
  const { data: options, isLoading: isLoadingOptions, error: errorOptions } = useReporteFormOptionsApi()
  const form = useReporteForm()

  const updateActiveFilters = useCallback(() => {
    const { periodo, categorias, cuentas } = formatActiveFilters(form.data)
    setActiveReportFilters.setPeriodo(periodo)
    setActiveReportFilters.setCategorias(categorias)
    setActiveReportFilters.setCuentas(cuentas)
  }, [form.data, setActiveReportFilters])

  const { mutate, isPending, validationErrors, reset } = useGenerateReportMutation(
    (data) => {
      setData(data)
      updateActiveFilters()
      toastHelper.success('Reporte generado')
    },
    (errors) => {
      toastHelper.error('Error al generar reporte')
      
      
    }
  )

  useEffect(() => {
    setIsLoading(isPending)
  }, [isPending, setIsLoading])

  const handleSubmit = useCallback(
    async (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault()
      form.clearErrors()
      await mutate(form.data)
    },
    [form, mutate]
  )

  const mergedErrors = { ...form.errors, ...validationErrors }

  if (errorOptions) {
    return (
      <SheetContent>
        <div className="text-red-500 text-center font-bold">Error al cargar opciones del formulario</div>
      </SheetContent>
    )
  }

  return (
    <SheetContent className="layout-background flex flex-col overflow-y-auto scrollbar-modern">
      <SheetHeader>
        <SheetTitle className="text-foreground">Generar Reporte</SheetTitle>
        <SheetDescription>
          Realiza los filtros para generar un reporte detallado de tu actividad financiera
        </SheetDescription>
      </SheetHeader>

      <div className="flex-1 overflow-y-auto py-4">
        {isLoadingOptions ? (
          <div className="flex justify-center items-center p-8">
            <i className="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
          </div>
        ) : (
          <ReporteForm
            data={form.data}
            setData={form.setData}
            errors={mergedErrors}
            onSubmit={handleSubmit}
            isLoading={isPending}
            options={options}
          />
        )}
      </div>

      <SheetFooter className="border-t border-border pt-4">
        <SheetClose asChild>
          <button
            type="button"
            className="px-4 py-2 text-muted-foreground hover:bg-accent rounded"
            onClick={() => {
              reset()
            }}
          >
            Cerrar
          </button>
        </SheetClose>
      </SheetFooter>
    </SheetContent>
  )
}