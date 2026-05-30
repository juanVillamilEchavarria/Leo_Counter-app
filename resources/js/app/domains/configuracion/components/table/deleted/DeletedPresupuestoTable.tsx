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
import { deletedPresupuestoColumns } from "../../columns/deleted/presupuesto/deleted.presupuesto.columns";
import { type PresupuestoHistoricoTableData } from "@/app/domains/presupuestoHistorico/types/presupuesto.types";
import { type DeletedDomainModalTypes } from "../../columns/deleted/utils/configuracion.deleted.columns.utils";

export default function DeletedPresupuestoTable({
    data,
    onSelect
}:{
    data: PresupuestoHistoricoTableData[]
    onSelect: (item: PresupuestoHistoricoTableData, modalType: DeletedDomainModalTypes) => void
}) {
    const columns = useMemo(()=>{
        return deletedPresupuestoColumns({
          onSelect: (item: PresupuestoHistoricoTableData, modalType: DeletedDomainModalTypes) => {
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
