import TanStackTable from "@/app/shared/components/table/advanced/TanStackTable"
import { ColumnsTableMovimientos } from "@/app/domains/movimiento"
import data from '../../../../../../MOCK_DATA.json'
export default function MovimientoTable() {
  return (
    <TanStackTable
           columns={ColumnsTableMovimientos}
           data={data}
            />
  )
}
