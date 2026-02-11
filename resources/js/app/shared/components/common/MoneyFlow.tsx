import SuccessOrFailText from "./SuccessOrFailText"
import { moneyFormat } from "../../helpers"

export default function MoneyFlow({
    tipo_movimiento,
    monto,
}:{
    tipo_movimiento: string,
    monto: number
}) {
  const signo = tipo_movimiento === 'Ingreso' ? '+' : '-'
return (
    <div className="flex items-center">
    <SuccessOrFailText output={signo + moneyFormat(Number(monto))} attribute={tipo_movimiento} value={'Ingreso'}  />
    </div>
)
}
