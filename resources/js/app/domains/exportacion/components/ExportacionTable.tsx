/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import TanStackTableServerSide from '@/app/shared/components/table/advanced/TanStackTableServerSIde';
import { useMemo } from 'react';
import { ExportacionColumns } from './columns/exportacion.columns';
import { ExportacionApiActions } from '../types/exportacion.types';
import type { ExportacionTableData } from '../types/exportacion.types';

export default function ExportacionTable() {
  const columns = useMemo(() => ExportacionColumns, []);

  return (
    <TanStackTableServerSide<ExportacionTableData>
      columns={columns}
      endpoint={ExportacionApiActions.paginatedData}
      queryKey={['exportaciones', 'historial']}
      pageSize={10}
    />
  );
}