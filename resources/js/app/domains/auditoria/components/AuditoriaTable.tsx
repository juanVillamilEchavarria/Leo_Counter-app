/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import TanStackTableServerSide from "@/app/shared/components/table/advanced/TanStackTableServerSIde"
import { useMemo } from "react"
import { AuditoriaColumns } from "./columns/auditoria.columns"
import type { AuditoriaTableData, Auditoria } from "../types/auditoria.types"
import { AuditoriaApiActions } from "../types/auditoria.types"

/**
 * Componente organismo que renderiza la tabla server-side de auditorías.
 * Reutiliza el componente compartido TanStackTableServerSide.
 */
export default function AuditoriaTable() {
   const columns = useMemo(() => AuditoriaColumns(), [])

  return (
    <>
        <TanStackTableServerSide<AuditoriaTableData>
            columns={columns}
            endpoint={AuditoriaApiActions.paginatedData}
            queryKey={['auditorias']}
            pageSize={10}
        />
    </>
  )
}
