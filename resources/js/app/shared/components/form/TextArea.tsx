/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type TextAreaProps } from "../../types/components"
export default function TextArea({
    name,
    id,
    value,
    placeholder,
    onChange,
    className='',
    icon,
    disabled = false,
    required = false
}:TextAreaProps) {
  return icon ? (
    <div className="flex relative">
        <i className={`absolute top-3 left-2 ${icon}`}></i>
        <textarea name={name} id={id} value={value || ''} onChange={onChange} className={` pl-10 formulario-fillable ${className}`} disabled={disabled} required={required} placeholder={placeholder}></textarea> 
    </div>  
  ):(
    <textarea name={name} id={id} value={value} onChange={onChange} className={`formulario-fillable ${className}`} disabled={disabled} required={required} placeholder={placeholder}></textarea>
  )
}
