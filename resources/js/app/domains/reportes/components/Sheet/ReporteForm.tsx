import InputFillable from "@/app/shared/components/form/InputFillable"
import SelectModel from "@/app/shared/components/form/SelectModel"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { useMultiSelect } from "@/app/shared/hooks"
import ItemsSelectedListGroup from "./ItemsSelectedListGroup"
import { type ReporteFormData, type ReporteFormOptionsApiReponse } from "../../types/reporte.types"
import { type Categoria } from "../../../categoria"
import { type Cuenta } from "../../../cuenta"
import type React from "react"

interface ReporteFormProps {
  data: ReporteFormData
  setData: (key: keyof ReporteFormData, value: any) => void
  errors: Record<string, string>
  onSubmit: React.FormEventHandler<HTMLFormElement>
  isLoading?: boolean
  options: ReporteFormOptionsApiReponse | undefined
}

export default function ReporteForm({
  data,
  setData,
  errors,
  onSubmit,
  isLoading = false,
  options,
}: ReporteFormProps) {
  const { addItem: addCategoria, removeItem: removeCategoria } = useMultiSelect<Categoria>({
    items: data.categorias,
    setItems: (categorias) => setData('categorias', categorias),
  })

  const { addItem: addCuenta, removeItem: removeCuenta } = useMultiSelect<Cuenta>({
    items: data.cuentas,
    setItems: (cuentas) => setData('cuentas', cuentas),
  })

  const handleAddCategoriaIngreso = (e: React.ChangeEvent<HTMLSelectElement>) => {
    handleAddCategoria(options?.data.categorias.ingresos, Number(e.target.value))
  }

  const handleAddCategoriaGasto = (e: React.ChangeEvent<HTMLSelectElement>) => {
    handleAddCategoria(options?.data.categorias.gastos, Number(e.target.value))
  }

  const handleAddCategoria = (categorias: Categoria[] | undefined, id: number) => {
    if (categorias === undefined) return
    const categoria = categorias.find(c => c.id === Number(id))
    if (categoria) addCategoria(categoria)
  }

  const handleAddCuenta = (e: React.ChangeEvent<HTMLSelectElement>) => {
    const cuenta = options?.data.cuentas.find(c => c.id === Number(e.target.value))
    if (cuenta) addCuenta(cuenta)
  }

  const isFormValid = true
  return (
    <form className="formulario-general h-full flex flex-col gap-4" onSubmit={onSubmit}>
      {/* Solo Categorías Fijas */}
      <div className="flex items-center gap-3">
        <input
          type="checkbox"
          name="only_categorias_fijas"
          id="only_categorias_fijas"
          checked={data.only_categorias_fijas}
          onChange={(e) => setData('only_categorias_fijas', e.target.checked)}
          className="cursor-pointer w-4 h-4"
        />
        <label className="font-semibold cursor-pointer" htmlFor="only_categorias_fijas">
          Solo Categorías Fijas
        </label>
      </div>

      {/* Categorías Condicionales */}
      <TransitionMotion active={data.only_categorias_fijas === false} exit={{ x: 0, y: -20, opacity: 0 }}>
        <div className="space-y-4">
          <div className="formulario-campo">
            <label htmlFor="categorias_ingreso">Categorías de ingreso</label>
            <SelectModel
              name="categorias_ingreso"
              id="categorias_ingreso"
              placeholder="Seleccione una categoría"
              value=""
              iterable={options?.data.categorias.ingresos ?? []}
              onChange={handleAddCategoriaIngreso}
              className={errors.categorias && 'border-red-500! text-red-500!'}
            />
          </div>

          <div className="formulario-campo">
            <label htmlFor="categorias_gasto">Categorías de gasto</label>
            <SelectModel
              name="categorias_gasto"
              id="categorias_gasto"
              placeholder="Seleccione una categoría"
              value=""
              iterable={options?.data.categorias.gastos ?? []}
              onChange={handleAddCategoriaGasto}
              className={errors.categorias && 'border-red-500! text-red-500!'}
            />
            <TransitionMotion active={!!errors.categorias}>
              <AlertMessage message={errors.categorias} />
            </TransitionMotion>
          </div>
        </div>
      </TransitionMotion>

      {/* Cuentas */}
      <div className="formulario-campo">
        <label htmlFor="cuenta_id">Cuentas</label>
        <SelectModel
          name="cuenta_id"
          id="cuenta_id"
          placeholder="Seleccione una cuenta"
          value=""
          iterable={options?.data.cuentas ?? []}
          onChange={handleAddCuenta}
          className={errors.cuentas && 'border-red-500! text-red-500!'}
        />
        <TransitionMotion active={!!errors.cuentas}>
          <AlertMessage message={errors.cuentas} />
        </TransitionMotion>
      </div>

      {/* Rango de Fechas */}
      <fieldset className="border border-border rounded-lg p-4">
        <legend className="font-semibold text-gray-700 px-2">
          Rango de fechas <span className="text-red-500">*</span>
        </legend>
        <div className="flex flex-col w-full gap-1 mt-3">
          <div className="formulario-campo flex-1">
            <label htmlFor="fecha_inicio">Fecha de inicio</label>
            <InputFillable
              type="date"
              onChange={(e) => setData('startDate', e.target.value)}
              name="fecha_inicio"
              id="fecha_inicio"
              value={data.startDate}
              className={errors.startDate && 'border-red-500! text-red-500!'}
            />
            <TransitionMotion active={!!errors.startDate}>
              <AlertMessage message={errors.startDate} />
            </TransitionMotion>
          </div>

          <div className="formulario-campo flex-1">
            <label htmlFor="fecha_fin">Fecha de fin</label>
            <InputFillable
              type="date"
              onChange={(e) => setData('endDate', e.target.value)}
              name="fecha_fin"
              id="fecha_fin"
              value={data.endDate}
              min={data.startDate}
              className={errors.endDate && 'border-red-500! text-red-500!'}
            />
            <TransitionMotion active={!!errors.endDate}>
              <AlertMessage message={errors.endDate} />
            </TransitionMotion>
          </div>
        </div>
      </fieldset>

      {/* Items Seleccionados */}
      <ItemsSelectedListGroup
        cuentas={data.cuentas}
        categorias={data.categorias}
        only_categorias_fijas={data.only_categorias_fijas}
        removeCategoria={removeCategoria}
        removeCuenta={removeCuenta}
      />

      {/* Submit Button */}
      <div className="mt-auto">
        <Button type="submit" variant="primary" disabled={!isFormValid || isLoading}>
          {isLoading ? 'Generando...' : 'Generar Reporte'}
        </Button>
      </div>
    </form>
  )
}
