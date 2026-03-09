import { SheetContent, SheetClose, SheetDescription, SheetHeader, SheetTitle, SheetFooter } from "@/app/shared/components/ui/sheet"
import Button from "@/app/shared/components/common/Button"
import ReporteForm from "./ReporteForm"
import ItemSelected from "@/app/shared/components/common/ItemSelected"
import useReporteFormOptionsApi from "../../hooks/useReporteFormOptionsApi"
import { useMultiSelect } from "@/app/shared/hooks"
import { type Categoria } from "@/app/domains/categoria"
import { type Cuenta } from "@/app/domains/cuenta"
import { useState } from "react"

export default function ReporteSheetContent() {
  const { data: options, isLoading, error } = useReporteFormOptionsApi()
  const { selectedItems: categoriasSelected, addItem: addCategoria, removeItem: removeCategoria } = useMultiSelect<Categoria>()
  const { selectedItems: cuentasSelected, addItem: addCuenta, removeItem: removeCuenta } = useMultiSelect<Cuenta>()
  const [onlyCategoriasFijas, setOnlyCategoriasFijas] = useState(false)

  if (error) {
    return (
      <SheetContent>
        <div className="text-red-500 text-center font-bold">Error al cargar opciones</div>
      </SheetContent>
    )
  }

  return (
    <SheetContent className="layout-background flex flex-col">
      <SheetHeader>
        <SheetTitle className="text-gray-900">Generar Reporte</SheetTitle>
        <SheetDescription>
          Realiza los filtros para generar un reporte detallado de tu actividad financiera
        </SheetDescription>
      </SheetHeader>
      
      <div className="my-5">
        {isLoading ? (
          <div className="flex justify-center items-center p-8">
            <i className="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
          </div>
        ) : (
          <ReporteForm options={options} addCategoria={addCategoria} addCuenta={addCuenta} setOnlyCategoriasFijas={setOnlyCategoriasFijas} onlyCategoriasFijas={onlyCategoriasFijas} />
        )}
      </div>
      <div className="flex flex-col gap-2">
        <p className="text-sm text-gray-500">Cuentas seleccionadas:</p>
        <div className="">
          <ul className="flex flex-wrap gap-2">
            {cuentasSelected.length>0 ? cuentasSelected.map((cuenta) => (
                <li key={cuenta.id}><ItemSelected name={cuenta.nombre} onRemove={() => removeCuenta(cuenta.id)} />
                </li>
              
            )):(
              <div className="w-full text-center">
                <p className="text-sm text-gray-500"> No hay cuentas seleccionadas</p>
              </div>
              
            )}
        </ul>
        </div>

        <p className="text-sm text-gray-500">Categorias seleccionadas:</p>
        <div className="">
          <ul className="flex flex-wrap gap-2">
            {categoriasSelected.length>0 ? categoriasSelected.map((categoria) => (
                <li key={categoria.id}><ItemSelected name={categoria.nombre} onRemove={() => removeCategoria(categoria.id)} />
                </li>
              
            )):(
              <div className="w-full text-center">
                {onlyCategoriasFijas === true ? (
                  <p className="text-sm text-blue-500 bg-blue-100 rounded-full px-3 py-1">Todas las categorias fijas seleccionadas</p>
                ):(
                  <p className="text-sm text-gray-500">No hay categorias seleccionadas</p>
                )}
                 
              </div>
             
            )}
        </ul>
        </div>
      </div>
      
      
      <SheetFooter className="mt-auto flex flex-col! gap-2 w-full">
        <Button type="submit" variant="primary">Generar</Button>
        <SheetClose asChild>
          <Button variant="gray">Cerrar</Button>
        </SheetClose>
      </SheetFooter>
    </SheetContent>
  )
}