import InputFillable from "@/app/shared/components/form/InputFillable"
import SelectModel from "@/app/shared/components/form/SelectModel"

export default function ReporteForm() {
  return (
    <form className="formulario-general" action="">
        <div className="formulario-campo">
          <label htmlFor="categoria_id">Categoría</label>
          <SelectModel name="categoria_id" id="categoria_id" placeholder="Seleccione una categoría" value={''} iterable={[]} onChange={()=>{}}/>
        </div>
        <div className="formulario-campo">
            <label htmlFor="tipo_movimiento_id">Tipo de movimiento</label>
            <SelectModel name="tipo_movimiento_id" id="tipo_movimiento_id" placeholder="Seleccione un tipo de movimiento" value={''} iterable={[]} onChange={()=>{}}/>
        </div>
        <div className="formulario-campo">
            <label htmlFor="cuenta_id">Cuenta</label>
            <SelectModel name="cuenta_id" id="cuenta_id" placeholder="Seleccione una cuenta" value={''} iterable={[]} onChange={()=>{}}/>
        </div>
        <p className="font-bold text-lg">Rango de fechas</p>
        <div className="flex w-full gap-2">
            <div className="formulario-campo">
                <label htmlFor="fecha_inicio">Fecha de inicio</label>
                <InputFillable type="date" onChange={()=>{}} name="fecha_inicio" id="fecha_inicio" value={''}  />
            </div>
            <div className="formulario-campo">
                <label htmlFor="fecha_fin">Fecha de fin</label>
                <InputFillable type="date" onChange={()=>{}} name="fecha_fin" id="fecha_fin" value={''}  />
            </div>
        </div>
    </form>
  )
}
