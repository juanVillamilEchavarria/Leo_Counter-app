/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import type { ColumnDef } from '@tanstack/react-table';
import { dateFormat } from '@/app/shared/helpers';
import type { ExportacionTableData } from '../../types/exportacion.types';
import NameAndEmail from '@/app/shared/components/common/NameAndEmail';

/**
 * Funcion para decorar el formato de la exportacion
 */
const FormatBadge = ({ format }: { format: 'csv' | 'xlsx' }) => {
  const styles = format === 'csv'
    ? 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300'
    : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300';

  return (
    <span className={`inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${styles}`}>
      {format.toUpperCase()}
    </span>
  );
};

/**
 * 
 * @description Funcion para decorar la tabla exportada
 * @param param0 
 * @returns 
 */
const TableBadge = ({ table }: { table: string }) => (
  <span className="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 capitalize">
    {table.replace('_', ' ')}
  </span>
);

export const ExportacionColumns: ColumnDef<ExportacionTableData>[] = [
  {
    id: 'id',
    header: 'ID',
    accessorKey: 'id',
    enableHiding: true,

  },
  {
    id: 'user_name',
    header: 'Usuario',
    accessorKey: 'user_name',
    cell: ({ row }) => (
       <NameAndEmail name={row.original.user_name} email={row.original.user_email}/>
    ),
  },
  {
    id: 'table',
    header: 'Tabla',
    accessorKey: 'table',
    cell: ({ row }) => <TableBadge table={row.original.table} />,
  },
  {
    id: 'format',
    header: 'Formato',
    accessorKey: 'format',
    cell: ({ row }) => <FormatBadge format={row.original.format} />,
  },
  {
    id: 'records_count',
    header: 'Registros',
    accessorKey: 'records_count',
    cell: ({ row }) => (
      <span className="tabular-nums font-medium">{row.original.records_count.toLocaleString()}</span>
    ),
  },
  {
    id: 'filename',
    header: 'Archivo',
    accessorKey: 'filename',
    cell: ({ row }) => (
      <span className="truncate max-w-xs block" title={row.original.filename}>
        {row.original.filename}
      </span>
    ),
  },
  {
    id: 'created_at',
    header: 'Fecha',
    accessorKey: 'created_at',
    cell: ({ row }) => dateFormat(row.original.created_at),
  },
];