import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SectionTransition from "@/app/shared/components/common/SectionTransition"
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

  useEffect(()=>{
    if(data){
      setItem(data.data)
    }
  },[data])
  return (
    <SectionTransition>
        <SectionDescription title="Movimientos" paragraph="Mira el historial de tus ingresos y gastos" />
        <MovimientoTable onSelect={(item)=> open(item, 'show')} />
        <ShowMovimientoModal 
            movimiento={item}
            onClose={close}
            />
    </SectionTransition>
  )
}
