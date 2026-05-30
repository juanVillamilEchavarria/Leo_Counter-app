/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SuccessOrFailText from "./SuccessOrFailText"
interface PercentageFlowProps{
      as?: React.ElementType
    className?: string
    tipo_movimiento: string,
    percentage: number
}
/**
 * Funcion que muestra el porcentaje de aumento o disminucion de un valor dependiendo del tipo de movimiento
 * @param {string} className 
 * @param {string} flow 
 * @param {number} percentage 
 * @param {string} tipo_movimiento
 * @param {string} as
 * 
 * @returns el porcentaje de aumento o disminucion
 */
export default function PercentageFlow({
    as: Tag = 'span',
    className = '',
    tipo_movimiento,
    percentage,
}:PercentageFlowProps) {

  const signo = tipo_movimiento === 'Ingreso' ? '+' : '-'
  const icon = tipo_movimiento === 'Ingreso' ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down'
    return (
    <div className="flex items-center">
    <SuccessOrFailText 
    as={Tag} 
    className={className} 
    output={
      <div className="flex items-center gap-2">
        <i className={`fa-solid ${icon} text-lg`}></i>
        <p>{signo + percentage + '%'}</p>

      </div>
    } 
    attribute={tipo_movimiento} 
    value={'Ingreso'} 
     />
    </div>
  )
}
