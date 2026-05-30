/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
interface EmptyDataMessageProps {
    title ?: string
    paragraph : string
}
export default function EmptyDataMessage({
    title = 'No hay datos disponibles',
    paragraph
}: EmptyDataMessageProps) {
  return (
    <div className="flex flex-col items-center justify-center h-75 text-center space-y-3">
          <div className="text-muted-foreground">
            <i className="fa-solid fa-chart-line text-3xl"></i>
          </div>
          <div>
            <h4 className="font-semibold text-foreground">{title}</h4>
            <p className="text-sm text-muted-foreground">{paragraph}</p>
          </div>
        </div>
  )
}
