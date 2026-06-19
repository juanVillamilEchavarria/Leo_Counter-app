/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
import SectionDescriptionWithDetails from "@/app/shared/components/common/SectionDescriptionWithDetails"
import ShowMovimientoModal from "@/app/domains/movimiento/components/ShowMovimientoModal"
import { useEffect } from "react"
import { useModalItem } from "@/app/shared/hooks"
import { MovimientoTable, type Movimiento } from "@/app/domains/movimiento"
import { type MovimientoTableData, type MovimientoShowData } from "@/app/domains/movimiento"
export default function Index({
  data
}:{
  data?: {data: MovimientoShowData}
}) {
  const {item, modal, setItem, open, close}= useModalItem<MovimientoShowData>()
  const descriptionItems=[
    {
      title: 'Consulta el historial de tus movimientos',
      description: 'Revisa el historial completo de tus ingresos y gastos para tener un control total sobre tus finanzas',
      icon: 'fa-solid fa-clock-rotate-left !text-yellow-300'

    },
    {
      icon: 'fa-solid fa-chart-line !text-green-400',
      title: 'Filtra por parametros',
      description: 'Filtra tus movimientos por fecha, nombre , categoria, cuenta o monto para encontrar lo que buscas',
    },
    {
      icon: 'fa-solid fa-magnifying-glass !text-blue-400',
      title: 'Consulta con detalles tus movimientos',
      description: 'Obtén información detallada sobre cada uno de tus movimientos dando click encima de su nombre en la tabla de movimientos',
    }

  ]

  useEffect(()=>{
    if(data){
      setItem(data.data)
    }
  },[data])
  return (
    <SectionTransition>
        <SectionDescriptionWithDetails
         principalTitle="Movimientos" 
        paragraph="Mira el historial de tus ingresos y gastos"
        items={descriptionItems}
         />
        <MovimientoTable onSelect={(item)=> open(item, 'show')} />
        <ShowMovimientoModal 
            movimiento={item}
            onClose={close}
            />
    </SectionTransition>
  )
}
