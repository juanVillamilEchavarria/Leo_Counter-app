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
     <div className={`inline-flex rounded-lg border border-gray-200 p-1 bg-gray-50 ${className}`}>
            {options.map((option, index) => (
              <FilterOption key={index} {...option} />
            ))}
     </div>
  )
}
