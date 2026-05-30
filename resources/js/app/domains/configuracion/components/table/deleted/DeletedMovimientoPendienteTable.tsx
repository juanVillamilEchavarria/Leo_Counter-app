/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable";
import { useMemo } from "react";
import { deletedMovimientoPendienteColumns } from "../../columns/deleted/movimientoPendiente/deleted.movimientoPendiente.columns";
import { type MovimientoPendienteTableData } from "@/app/domains/movimientoPendiente/types/movimientoPendiente.types";
import { type DeletedDomainModalTypes } from "../../columns/deleted/utils/configuracion.deleted.columns.utils";

export default function DeletedMovimientoPendienteTable({
    data,
    onSelect
}:{
    data: MovimientoPendienteTableData[]
    onSelect: (item: MovimientoPendienteTableData, modalType: DeletedDomainModalTypes) => void
}) {
    const columns = useMemo(()=>{
        return deletedMovimientoPendienteColumns({
          onSelect: (item: MovimientoPendienteTableData, modalType: DeletedDomainModalTypes) => {
            onSelect(item, modalType)
          }
        })
        
    },[onSelect])
  return (
    <SimpleTable
      data={data}
      columns={columns}
      pagination={true}
      pageSize={10}
    />
  )
}
