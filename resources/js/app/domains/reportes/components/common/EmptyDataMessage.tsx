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
          <div className="text-gray-400">
            <i className="fa-solid fa-chart-line text-3xl"></i>
          </div>
          <div>
            <h4 className="font-semibold text-gray-900">{title}</h4>
            <p className="text-sm text-muted-foreground">{paragraph}</p>
          </div>
        </div>
  )
}
