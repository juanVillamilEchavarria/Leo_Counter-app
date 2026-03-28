import Card from "@/app/shared/components/common/Card"
import PercentageFlow from "@/app/shared/components/common/PercentageFlow"
import { moneyFormat } from "@/app/shared/helpers"
import type React from "react"
interface CardRevirewProps {
     label: string | React.ReactNode,
    percentage: number,
    tipo_movimiento?: string,
    total: number,
    tipo_total? : 'dinero' | 'numero'
    children? : React.ReactNode
    icon?: string
}
/**
 * Componente de que muestra las estadisticas de los KPI del reporte
 * @param {string | React.ReactNode} label 
 * @param {number} percentage 
 * @param {string} tipo_movimiento 
 * @param {number} total 
 * @param {'dinero' | 'numero'} tipo_total
 *  @param {React.ReactNode} children
 * @param {string | null} icon
 * 
 * @returns {JSX.Element}
 */

export default function CardReview({
    label,
    percentage,
    tipo_movimiento,
    total,
    tipo_total = 'dinero',
    children,
    icon
}:CardRevirewProps) {
    const variant = tipo_movimiento !== undefined 
    ? (tipo_movimiento === 'Ingreso' 
        ? 'successSecondary' :
         'dangerSecondary') 
    : 'secondary'

    const getIcon = () => {
        if (icon) return icon
        if (tipo_movimiento === 'Ingreso') return 'fa-arrow-trend-up'
        if (tipo_movimiento === 'Gasto') return 'fa-arrow-trend-down'
        return 'fa-chart-line'
    }

  return (
     <Card className="hover:shadow-lg transition-shadow duration-200 border-0 shadow-sm" variant={variant}>
        <div className="flex flex-col p-6">
            <div className="w-full flex items-center justify-between mb-4">
                <div className="flex items-center gap-3">
                    <div className="p-2 rounded-lg bg-muted">
                        <i className={`fa-solid ${getIcon()} text-muted-foreground`}></i>
                    </div>
                    <p className="text-sm font-medium text-muted-foreground">{label}</p>
                </div>
                <div className="bg-muted rounded-lg px-3 py-1">
                    <PercentageFlow className="text-sm font-semibold" tipo_movimiento={tipo_movimiento ?? 'Ingreso'} percentage={percentage} />
                </div>
            </div>
            <div className="flex justify-start items-center mb-3">
                <h1 className="text-3xl font-bold text-foreground">
                    {tipo_total === 'dinero' ? moneyFormat(total) : total.toLocaleString()}
                </h1>
            </div>
            {children && (
                <div className="border-t border-border pt-3">
                    {children}
                </div>
            )}
        </div>
    </Card>
  )
}
