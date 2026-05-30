/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import { type SelectModelProps } from "../../types/components"
export default function SelectModel<T extends Record<string, any>>({
    name,
    id,
    onChange,
    className='',
    placeholder,
    disabled = false,
    value,
    iterable,
    iterableOutput = 'nombre'
}:SelectModelProps<T>) {
  return (
    <select
        name={name}
        id={id}
        onChange={onChange}
        className={`select ${className}`}
        disabled={disabled}
        value={value}
    >
        <option  value=''>{placeholder ? `--- ${placeholder} --- ` : '-- Seleccione --'}

        </option>
        {
            iterable.map((item: T) => (
                <option key={item.id} value={item.id}>{item[iterableOutput]}</option>
            ))
        }
    </select>
  )
}
