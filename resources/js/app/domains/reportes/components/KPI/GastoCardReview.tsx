import CardReview from "./CardReview"

interface GastoCardReviewProps {
  total: number
  variacion: number | null
}

export default function GastoCardReview({ total, variacion }: GastoCardReviewProps) {
  const percentage = variacion ?? 0
  const trendMessage = percentage >= 0 ? "de Incremento en este periodo" : "de Decremento en este periodo"
  const trendColor = percentage >= 0 ? "text-red-600" : "text-green-600"
  const trendIcon = percentage >= 0 ? "fa-arrow-trend-up" : "fa-arrow-trend-down"
  const trendIconColor = percentage >= 0 ? "text-red-500" : "text-green-500"

  return (
    <CardReview
      label="Total de gastos"
      percentage={Math.abs(percentage)}
      tipo_movimiento="Gasto"
      total={total}
      tipo_total="dinero"
      icon="fa-arrow-down"
    >
      <div className="flex flex-col gap-2">
        <div className="flex items-center gap-2">
          <p className="text-sm font-medium text-gray-700">
            <span className={trendColor}>{Math.abs(percentage).toFixed(2)}%</span> {trendMessage}
          </p>
          <i className={`fa-solid ${trendIcon} ${trendIconColor}`}></i>
        </div>
        <small className="text-xs text-muted-foreground">
          {percentage >= 0 ? "¡Se recomienda revisar categorías principales!" : "Reducción de gastos positiva"}
        </small>
      </div>
    </CardReview>
  )
}
