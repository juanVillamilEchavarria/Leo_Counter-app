import Card from "@/app/shared/components/common/Card"
import PercentageFlow from "@/app/shared/components/common/PercentageFlow"
import { moneyFormat } from "@/app/shared/helpers"
import type React from "react"
export default function CardReview({
    label,
    monto,
    tipo_movimiento,
    total,
    flow = 'normal',
    tipo_total = 'dinero',
    children
}:{
    label: string | React.ReactNode,
    monto: number,
    tipo_movimiento?: string,
    total: number,
    flow? : 'normal' | 'reverse'
    tipo_total? : 'dinero' | 'numero'
    children? : React.ReactNode
}) {
    const variant = tipo_movimiento !== undefined ? tipo_movimiento === 'Ingreso' ? 'successSecondary' : 'dangerSecondary' : 'secondary'
  return (
     <Card className={``} variant={variant} >
        <div className="flex flex-col p-6">
            <div className="w-full flex items-center justify-between">
                <p className=" text-gray-500">{label}</p>
                <div className="bg-blue-200/40 rounded-2xl px-3 py-1">
                        <PercentageFlow flow={flow} className="text-sm"  tipo_movimiento={tipo_movimiento ?? 'Ingreso'} monto={monto} />
                </div>
            </div>
            <div className="mt-2 flex justify-start items-center">
            <h1 className="text-2xl">{tipo_total === 'dinero' ? moneyFormat(total) : total}</h1>
            </div>
            {children}
        </div>
    </Card>
  )
}
