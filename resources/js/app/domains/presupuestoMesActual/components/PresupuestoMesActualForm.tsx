import InputFillable from "@/app/shared/components/form/InputFillable"
import Card from "@/app/shared/components/common/Card"
import SelectModel from "@/app/shared/components/form/SelectModel"
import Button from "@/app/shared/components/common/Button"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import { type PresupuestoMesActualFormProps } from "../types/presupuestoMesActual.types"
export default function PresupuestoMesActualForm({
    data,
    setData,
    errors,
    submit,
    options,
    processing,
}: PresupuestoMesActualFormProps) {
  return (
    <Card>
      <form onSubmit={submit} className="formulario-general">
        <legend className="legend mt-5">Información del presupuesto</legend>
          <div className="formulario-campo">
            <label htmlFor="categoria_id">Categoria</label>
            <SelectModel
              name="categoria_id"
              id="categoria_id"
              value={data?.categoria_id}
              onChange={
                (e: React.ChangeEvent<HTMLSelectElement>) => setData('categoria_id', Number(e.target.value))
              }
              iterable={options.categorias}
              className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.categoria_id && 'border-red-500! text-red-500!'} `}
            />
            <TransitionMotion
            active={errors?.categoria_id}>
                <AlertMessage message={errors?.categoria_id} />
            </TransitionMotion>
          </div>
          <div className="formulario-campo">
            <label htmlFor="monto">Monto</label>
            <InputFillable 
              placeholder="Ej: 1000"
              type="number"
              name="monto"
              id="monto"
              value={data?.monto}
              onChange={
                (e: React.ChangeEvent<HTMLInputElement>) => setData('monto', Number(e.target.value))
              }
              className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.monto && 'border-red-500! text-red-500!'} `}
              icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.monto && 'text-red-500!'} `}
            />
            <TransitionMotion
            active={errors?.monto}>
                <AlertMessage message={errors?.monto} />
            </TransitionMotion>
          </div>
        <div className="w-1/6 my-5 mx-auto">
            <Button
            variant="secondary"
                type="submit"
                disabled={processing}
            >
                Guardar
            </Button>
        </div>
        
      </form>
    </Card>
  )
}
