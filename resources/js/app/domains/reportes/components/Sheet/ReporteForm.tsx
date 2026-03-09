import InputFillable from "@/app/shared/components/form/InputFillable"
import SelectModel from "@/app/shared/components/form/SelectModel"
import TransitionMotion from "@/app/shared/components/transitions/TransitionMotion"
import { type Categoria } from "../../../categoria"
import { type Cuenta } from "../../../cuenta"
import type React from "react"


interface ReporteFormOptionsProps {
  categorias: Categoria[],
  cuentas: Cuenta[]
  
}
interface ReporteFormOptions{
  options : ReporteFormOptionsProps | undefined,
 addCategoria: (categoria: Categoria) => void,
 addCuenta: (cuenta: Cuenta) => void,
 setOnlyCategoriasFijas: React.Dispatch<React.SetStateAction<boolean>>
 onlyCategoriasFijas: boolean
}
export default function ReporteForm({
  options,
  addCategoria,
  addCuenta,
  setOnlyCategoriasFijas,
  onlyCategoriasFijas
}: ReporteFormOptions

) {
  const HandleAddCategoria = (e : React.ChangeEvent<HTMLSelectElement>)=>{
        const categoria = options?.categorias.find(c => c.id === Number(e.target.value));
          if (categoria) addCategoria(categoria);
  }
  const HandleAddCuenta = (e : React.ChangeEvent<HTMLSelectElement>)=>{
        const cuenta = options?.cuentas.find(c => c.id === Number(e.target.value));
          if (cuenta) addCuenta(cuenta);
  }
  return (
    <form className="formulario-general" action="">
      <div className="flex items-center gap-2">
          <input type="checkbox" className="" name="categorias_fijas" id="categorias_fijas" onChange={()=>setOnlyCategoriasFijas(prev => !prev)} />
        <label className="font-bold" htmlFor="categorias_fijas">Solo Categorias Fijas</label>
  
      </div>
      <TransitionMotion 
      active={onlyCategoriasFijas=== false}
      exit={{x:0, y:-20, opacity:0}}
      >
        <div className="formulario-campo">
          <label htmlFor="categoria_id">Categorías</label>
          <SelectModel name="categoria_id" id="categoria_id" placeholder="Seleccione una categoría" value={''} iterable={options?.categorias ?? []} onChange={HandleAddCategoria}/>
        </div>

      </TransitionMotion>
        
        <div className="formulario-campo">
            <label htmlFor="cuenta_id">Cuentas</label>
            <SelectModel name="cuenta_id" id="cuenta_id" placeholder="Seleccione una cuenta" value={''} iterable={options?.cuentas ?? []} onChange={HandleAddCuenta}/>
        </div>
        <p className="font-bold text-lg">Rango de fechas <span className="text-red-500">*</span></p>
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
