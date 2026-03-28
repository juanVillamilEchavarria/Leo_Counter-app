import CardReview from "./CardReview"

interface MovimientosCardReviewProps {
  total: number
  variacion: number | null
}

export default function MovimientosCardReview({ total, variacion }: MovimientosCardReviewProps) {
  const percentage = variacion ?? 0
  const trendMessage = percentage >= 0 ? "superior en este mes" : "inferior en este mes"
  const trendColor = percentage >= 0 ? "text-green-600" : "text-red-600"
  const trendIcon = percentage >= 0 ? "fa-arrow-trend-up" : "fa-arrow-trend-down"
  const trendIconColor = percentage >= 0 ? "text-green-500" : "text-red-500"

  return (
    <CardReview
      label="Total de movimientos"
      percentage={Math.abs(percentage)}
      tipo_total="numero"
      total={total}
      icon="fa-exchange-alt"
    >
      <div className="flex flex-col gap-2">
        <div className="flex items-center gap-2">
          <p className="text-sm font-medium text-muted-foreground">
            Volumen de movimientos <span className={trendColor}>{Math.abs(percentage).toFixed(2)}%</span> {trendMessage}
          </p>
          <i className={`fa-solid ${trendIcon} ${trendIconColor}`}></i>
        </div>
        <small className="text-xs text-muted-foreground">
          {percentage >= 0 ? "Actividad financiera consistente" : "Actividad financiera en decremento"}
        </small>
      </div>
    </CardReview>
  )
}
