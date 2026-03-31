import { type InputFillableProps } from "@/app/shared/types/components"
/**
 * Componente de input rellenable, que se puede usar para crear campos de formulario, con un diseño predefinido y con la posibilidad de agregar un icono dentro del input, ademas de manejar el estado del input a través de props como value y onChange, y tambien permite deshabilitar el input o hacerlo requerido.
 * @param {string} placeholder - Placeholder del input
 * @param {string} icon - Clase del icono a mostrar dentro del input, si se proporciona
 * @param {string} type - Tipo de input, por defecto es 'text'
 * @param {string} name - Nombre del input
 * @param {string} id - Id del input
 * @param {string} value - Valor del input
 * @param {Function} onChange - Funcion que se ejecuta cuando se cambia el valor del input  
 * @param {string} className - Clases adicionales para el input
 * @param {number} min - Valor minimo para inputs de tipo number
 * @param {number} max - Valor maximo para inputs de tipo number
 * @param {boolean} disabled - Si el input esta deshabilitado o no, por defecto es false
 * @param {boolean} required - Si el input es requerido o no, por defecto es false
 * @returns {JSX.Element} Componente de input rellenable
 * @example
 * <InputFillable placeholder="Mi Nombre" icon="fa-solid fa-user" value={form.data.name} onChange={(e)=>form.setData('name', e.target.value)} />
 */
export default function InputFillable({
    placeholder = '',
    icon,
    type = 'text',
    name = '',
    id = '',
    value = '',
    onChange = () => {},
    className='',
    min,
    max,
    disabled = false,
    required = false,
}:InputFillableProps) {
  return icon ? (
    <div className="flex relative text-foreground">
        <i className={`absolute top-3 left-2 ${icon}`}></i>
        <input min={min} max={max} type={type} name={name} id={id} placeholder={placeholder} value={value} onChange={onChange} className={`pl-10  formulario-fillable ${className}`} disabled={disabled} required={required} />

    </div>
  ):(
    <input min={min} max={max} type={type} name={name} id={id} placeholder={placeholder} value={value} onChange={onChange} className={`formulario-fillable  ${className}`} disabled={disabled} required={required} />
  )
}
