import { type InputFillableProps } from "@/app/shared/types/components"
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
    <div className="flex relative">
        <i className={`absolute top-3 left-2 ${icon}`}></i>
        <input min={min} max={max} type={type} name={name} id={id} placeholder={placeholder} value={value} onChange={onChange} className={`pl-10  formulario-fillable ${className}`} disabled={disabled} required={required} />

    </div>
  ):(
    <input min={min} max={max} type={type} name={name} id={id} placeholder={placeholder} value={value} onChange={onChange} className={`formulario-fillable  ${className}`} disabled={disabled} required={required} />
  )
}
