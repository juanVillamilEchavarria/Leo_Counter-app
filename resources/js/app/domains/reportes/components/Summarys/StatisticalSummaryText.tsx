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
export default function StatisticalSummaryText({
  color,
  valueColor,
  value,
  text,
  type = 'money'
}: StatisticalSummaryTextProps) {
  const valueFormated = useMemo(() => {
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
