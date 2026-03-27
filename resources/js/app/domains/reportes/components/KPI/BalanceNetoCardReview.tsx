import CardReview from "./CardReview"

interface BalanceNetoCardReviewProps {
  total: number
  variacion: number | null
}

export default function BalanceNetoCardReview({ total, variacion }: BalanceNetoCardReviewProps) {
  const percentage = variacion ?? 0
  const isPositive = total >= 0
  const trendMessage = "Respecto al periodo anterior"
  const trendColor = percentage >= 0 ? "text-green-600" : "text-red-600"
  const trendIcon = percentage >= 0 ? "fa-arrow-trend-up" : "fa-arrow-trend-down"
  const trendIconColor = percentage >= 0 ? "text-green-500" : "text-red-500"
  const tipoMovimiento = isPositive ? "Ingreso" : "Gasto"

  return (
    <CardReview
      label="Balance neto"
      percentage={Math.abs(percentage)}
      tipo_movimiento={tipoMovimiento}
      total={total}
      tipo_total="dinero"
      icon="fa-scale-balanced"
    >
      <div className="flex flex-col gap-2">
        <div className="flex items-center gap-2">
          <p className="text-sm font-medium text-gray-700">
            <span className={trendColor}>
              {isPositive ? "+" : "-"} {Math.abs(percentage).toFixed(2)}%
            </span> {trendMessage}
          </p>
          <i className={`fa-solid ${trendIcon} ${trendIconColor}`}></i>
        </div>
        <small className="text-xs text-muted-foreground">
          {isPositive ? "Balance positivo en el período" : "Balance negativo, requiere atención"}
        </small>
      </div>
    </CardReview>
  )
}
