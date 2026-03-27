import CardReview from "./CardReview"

interface IngresoCardReviewProps {
  total: number
  variacion: number | null
}

export default function IngresoCardReview({ total, variacion }: IngresoCardReviewProps) {
  const percentage = variacion ?? 0
  const trendMessage = percentage >= 0 ? "de Incremento en este mes" : "de Decremento en este mes"
  const trendColor = percentage >= 0 ? "text-green-600" : "text-red-600"
  const trendIcon = percentage >= 0 ? "fa-arrow-trend-up" : "fa-arrow-trend-down"
  const trendIconColor = percentage >= 0 ? "text-green-500" : "text-red-500"

  return (
    <CardReview
      label="Total de ingresos"
      percentage={Math.abs(percentage)}
      tipo_movimiento="Ingreso"
      total={total}
      tipo_total="dinero"
      icon="fa-arrow-up"
    >
      <div className="flex flex-col gap-2">
        <div className="flex items-center gap-2">
          <p className="text-sm font-medium text-gray-700">
            <span className={trendColor}>{Math.abs(percentage).toFixed(2)}%</span> {trendMessage}
          </p>
          <i className={`fa-solid ${trendIcon} ${trendIconColor}`}></i>
        </div>
        <small className="text-xs text-muted-foreground">
          {percentage >= 0 ? "Tendencia positiva en generación de ingresos" : "Se recomienda revisar la generación de ingresos"}
        </small>
      </div>
    </CardReview>
  )
}
