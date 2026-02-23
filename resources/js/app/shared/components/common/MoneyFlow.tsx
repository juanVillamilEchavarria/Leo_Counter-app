import SuccessOrFailText from "./SuccessOrFailText"
import { moneyFormat } from "../../helpers"

export default function MoneyFlow({
    as: Tag = 'span',
    className = '',
    tipo_movimiento,
    monto,
}:{
    as?: React.ElementType
    className?: string
    tipo_movimiento: string,
    monto: number
}) {
  const signo = tipo_movimiento === 'Ingreso' ? '+' : '-'
return (
    <div className="flex items-center">
    <SuccessOrFailText as={Tag} className={className} output={signo + moneyFormat(Number(monto))} attribute={tipo_movimiento} value={'Ingreso'}  />
    </div>
)
}
