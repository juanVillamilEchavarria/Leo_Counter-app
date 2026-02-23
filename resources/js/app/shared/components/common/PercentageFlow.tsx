
import SuccessOrFailText from "./SuccessOrFailText"
export default function PercentageFlow({
    as: Tag = 'span',
    className = '',
    tipo_movimiento,
    flow ='normal',
    monto,
}:{
    as?: React.ElementType
    className?: string
    flow ? : 'normal' | 'reverse'
    tipo_movimiento: string,
    monto: number
}) {
  const signo = tipo_movimiento === 'Ingreso'  ? flow === 'normal' ? '+' : '-' : flow === 'normal' ? '-' : '+'
  return (
    <div className="flex items-center">
    <SuccessOrFailText as={Tag} className={className} output={signo + monto + '%'} attribute={tipo_movimiento} value={'Ingreso'}  />
    </div>
  )
}
