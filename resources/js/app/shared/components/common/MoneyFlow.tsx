/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
