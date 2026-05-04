import React from 'react'
import { moneyFormat } from '@/app/shared/helpers'
import { useMemo } from 'react'

type Types = 'money' | 'percentage' | 'number'
interface StatisticalSummaryTextProps {
  color: string
  valueColor: string
  value: number
  text: string
  type ? :  Types
}
/**
 * Componente para los textos que muestran un resumen estadistico para un grafico, devuelve el texto con un circulo de color, el texto, y el valor con el color correspondiente.
 * 
 * Ejemplo : () Ingresos : $1000,00
 * @param {string} color - el color del circulo
 * @param {string} valueColor - el color del valor (numero)
 * @param {number} value - el valor
 * @param {string} text - el texto
 * @param {'money' | 'percentage' | 'number'} type - que tipo de valor es el que se muestra
 * @returns 
 */
export default function StatisticalSummaryText({
  color,
  valueColor,
  value,
  text,
  type = 'money'
}: StatisticalSummaryTextProps) {
  const valueFormated = useMemo(() => {
    if (value === null) return '-'
    if (type === 'money') return moneyFormat(value)
    if (type === 'percentage') return `${value}%`
    return value
  }, [type, value])
  return (
    <div className="flex items-center gap-2">
      <div className={`w-3 h-3 rounded-full ${color}`}></div>
      <span className="text-muted-foreground">{text}</span>
      <span className={`font-semibold ${valueColor}`}>{valueFormated}</span>
    </div>
  )
}
