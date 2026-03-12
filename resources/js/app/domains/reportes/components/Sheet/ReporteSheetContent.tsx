import { SheetContent, SheetClose, SheetDescription, SheetHeader, SheetTitle, SheetFooter } from "@/app/shared/components/ui/sheet"
import ReporteForm from "./ReporteForm"
import useReporteFormOptionsApi from "../../hooks/api/useReporteFormOptionsApi"
import { useReporteForm } from "../../hooks/useReporteForm"
import { useGenerateReportMutation } from "../../hooks/api/useGenerateReportMutation"
import { useCallback } from "react"

export default function ReporteSheetContent() {
  const { data: options, isLoading: isLoadingOptions, error: errorOptions } = useReporteFormOptionsApi()
  const form = useReporteForm()
  const { mutate, isPending, validationErrors, reset } = useGenerateReportMutation(
    // funcion de succes (exito)
    (data) => {
      console.log('Reporte generado exitosamente:', data)
    },
    // funcion de error
    (errors) => {
      console.error('Errores de validación:', errors)
    }
  )

  const handleSubmit = useCallback(
    async (e: React.FormEvent<HTMLFormElement>) => {
      e.preventDefault()
      form.clearErrors()
      await mutate(form.data)
    },
    [form, mutate]
  )

  // Merge validationErrors from API with form errors
  const mergedErrors = { ...form.errors, ...validationErrors }

  if (errorOptions) {
    return (
      <SheetContent>
        <div className="text-red-500 text-center font-bold">Error al cargar opciones del formulario</div>
      </SheetContent>
    )
  }

  return (
    <SheetContent className="layout-background flex flex-col overflow-y-auto">
      <SheetHeader>
        <SheetTitle className="text-gray-900">Generar Reporte</SheetTitle>
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

      <SheetFooter className="border-t pt-4">
        <SheetClose asChild>
          <button
            type="button"
            className="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded"
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