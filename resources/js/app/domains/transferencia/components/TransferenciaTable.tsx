/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import { useMemo } from "react";
import { TransferenciaColumns } from "./columns/transferencia.columns";
import { type Transferencia, TransferenciaApiActions } from "../types/transferencia.types";
import TanStackTableServerSide from "@/app/shared/components/table/advanced/TanStackTableServerSIde";

export default function TransferenciaTable({
  pageSize = 10,
}: {
  pageSize?: number
}) {
  const columns = useMemo(() => {
    return TransferenciaColumns();
  }, []);

  return (
    <TanStackTableServerSide<Transferencia>
      columns={columns}
      pageSize={pageSize}
      endpoint={TransferenciaApiActions.paginatedData}
      queryKey={['transferencias']}
    />
  )
}
