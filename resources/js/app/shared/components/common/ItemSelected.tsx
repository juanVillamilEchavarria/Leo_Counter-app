/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
interface ItemSelectedProps {
  name: string
  onRemove: () => void
}

export default function ItemSelected({ name, onRemove }: ItemSelectedProps) {
  return (
    <div className="relative inline-flex items-center gap-2 bg-blue-100 hover:bg-blue-200 border border-blue-300 px-3 py-1.5 pr-8 rounded-full shadow-sm transition-colors">
      <span className="text-blue-800 text-sm font-medium">{name}</span>
      <button
        type="button"
        onClick={onRemove}
        className="absolute right-1 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center  hover:text-primary-foreground text-blue-600 rounded-full transition-colors"
        aria-label={`Remover ${name}`}
      >
        <i className="fa-solid fa-xmark text-xs"></i>
      </button>
    </div>
  )
}