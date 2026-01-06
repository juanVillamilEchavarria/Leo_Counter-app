import SectionDescription from "@/app/shared/components/common/SectionDescription"
import SimpleTanStackTable from "@/app/shared/components/table/SimpleTanStackTable"
import CreateButtonSection from "@/app/shared/components/common/CreateButtonSection"
import CrudButton from "@/app/shared/components/common/CrudButton"
import { Link } from "@inertiajs/react"
import { ColumnsTableMovimientosMesActual } from "@/app/domains/movimiento/types/mesActual/movimientosMesActual.types"
import { dateFormat } from "@/app/shared/helpers"
import { type MovimientosMesActualProps } from "@/app/domains/movimiento"
export default function Index({
  inicio,
  fin
}:MovimientosMesActualProps
) {
  return (
    <div className="section">
      
        <SectionDescription title={`Movimientos Del Mes Actual `} paragraph={` ${dateFormat(inicio)} - ${dateFormat(fin)}
        `} />
        <CreateButtonSection>
          <CrudButton
                as={Link}
                href="#"
                icon="fa-solid fa-earth-americas "
                />
        </CreateButtonSection>
         <SimpleTanStackTable
                columns={ColumnsTableMovimientosMesActual}
                data={[
                  {
                    id: 1,
                    nombre: 'Miguel'
                  }
                ]}
            />
    </div>
  )
}
