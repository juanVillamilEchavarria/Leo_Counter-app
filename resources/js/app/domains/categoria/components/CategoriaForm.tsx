import InputFillable from "@/app/shared/components/form/InputFillable"
import Card from "@/app/shared/components/common/Card"
import AlertMessage from "@/app/shared/components/common/AlertMessage"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import TextArea from "@/app/shared/components/form/TextArea"
import Button from "@/app/shared/components/common/Button"
import { type CategoriaFormProps } from "../types/categoria.types"
export default function CategoriaForm({
  data,
    setData,
    errors,
    submit,
    options,
    processing,
}: CategoriaFormProps) {
  console.log(submit)
  return (
    <Card>
    <form onSubmit={submit} className="formulario-general">
        <legend className="legend mt-5">Información de la categoría</legend>
        <div className="flex w-full gap-4">
          <div className="formulario-campo w-full">
              <label htmlFor="nombre">Nombre de la categoría</label>
              <InputFillable 
                placeholder="Ej: Alimentacion"
                type="text"
                name="nombre"
                id="nombre"
                value={data?.nombre}
                onChange={
                  (e: React.ChangeEvent<HTMLInputElement>) => setData('nombre', e.target.value)
                }
                className={`border-2 p-3 border-gray-300 text-gray-800 ${errors.nombre && 'border-red-500! text-red-500!'} `}
                icon={`fa-solid fa-file-signature fa-xl top-6 text-gray-400 ${errors.nombre && 'text-red-500!'} `}
              />
              <TransitionMotion
              active={errors?.nombre}
              >
                  <AlertMessage message={errors?.nombre} />

              </TransitionMotion>
                
        </div>
          <div className="formulario-campo w-full">
              <label htmlFor="tipo">Tipo de movimiento</label>
              <select
                name="tipo_movimiento_id"
                id="tipo_movimiento_id"
                value={data?.tipo_movimiento_id}
                onChange={(e: React.ChangeEvent<HTMLSelectElement>) => setData('tipo_movimiento_id', Number(e.target.value))}
               className={`select ${errors.tipo_movimiento_id && 'border-red-500! text-red-500!'}`} 
              >
                <option value="">---Seleccione un tipo---</option>
                {
                  options.tipos.map((tipo) => (
                    <option key={tipo.id} value={tipo.id}>{tipo.tipo_movimiento}</option>
                  ))
                }
              </select>
              <TransitionMotion
              active={errors?.tipo_movimiento_id}
              >
                  <AlertMessage message={errors?.tipo_movimiento_id} />

              </TransitionMotion>
          </div>

        </div>
        
        <div className="formulario-campo">
          <label htmlFor="descripcion">Descripción</label>
          <TextArea 
            placeholder="Descripción de la categoría"
            name="descripcion"
            id="descripcion"
            value={data?.descripcion}
            onChange={
              (e: React.ChangeEvent<HTMLTextAreaElement>) => setData('descripcion', e.target.value)
            }
            className={`border-2 p-3 border-gray-300 text-gray-800 h-60 ${errors.descripcion && 'border-red-500! text-red-500!'} `}
          />
          <TransitionMotion
           active={errors?.descripcion}
          >
              <AlertMessage message={errors?.descripcion} />

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
