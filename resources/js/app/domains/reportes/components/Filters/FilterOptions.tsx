/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import FilterOption ,{ type FilterOptionProps } from './FilterOption'

interface FilterOptionsProps {
    options: FilterOptionProps[]
    className?: string
}
export default function FilterOptions({
    options,
    className = ''
}: FilterOptionsProps) {
  return (
     <div className={`inline-flex rounded-lg border border-border p-1 bg-muted ${className}`}>
            {options.map((option, index) => (
              <FilterOption key={index} {...option} />
            ))}
     </div>
  )
}
