
import SuccessOrFailText from "./SuccessOrFailText"
export default function PercentageFlow({
    as: Tag = 'span',
    className = '',
    tipo_movimiento,
    flow ='normal',
    percentage,
}:{
    as?: React.ElementType
    className?: string
    flow ? : 'normal' | 'reverse'
    tipo_movimiento: string,
    percentage: number
}) {
  
  const signo = tipo_movimiento === 'Ingreso'  ? flow === 'normal' ? '+' : '-' : flow === 'normal' ? '-' : '+'
  const icon = tipo_movimiento === 'Ingreso' ? flow === 'normal' ? 'fa-solid fa-arrow-trend-up' : 'fa-solid fa-arrow-trend-down': flow === 'normal' ? 'fa-solid fa-arrow-trend-down' : 'fa-solid fa-arrow-trend-up'
    return (
    <div className="flex items-center">
    <SuccessOrFailText as={Tag} className={className} output={
      <div className="flex items-center gap-2">
        <i className={`${icon} text-lg`}></i>
        <p>{signo + percentage + '%'}</p>

      </div>
    } attribute={tipo_movimiento} value={'Ingreso'}  />
    </div>
  )
}
