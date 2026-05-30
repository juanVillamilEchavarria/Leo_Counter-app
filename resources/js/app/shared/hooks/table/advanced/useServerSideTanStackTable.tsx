/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import {
    getCoreRowModel,
    useReactTable,
    type PaginationState,
    type SortingState,
} from '@tanstack/react-table';
import { useState, useMemo, type JSX } from 'react';
import useServerSideTable from "../config/useServerSideTable"
import { type UseServerSideTanStackTableProps } from '@/app/shared/types';
export default function useServerSideTanStackTable<T extends Record<string, any>>({
    columns,
    endpoint,
    queryKey,
    initialPageSize = 10
}: UseServerSideTanStackTableProps<T>) {
  const [pagination, setPagination] = useState<PaginationState>({
    pageIndex: 0,
    pageSize: initialPageSize,
  });
 
  const [sorting, setSorting] = useState<SortingState>([]);
  const [globalFilter, setGlobalFilter] = useState('');

  const { data : response, isLoading , isFetching, isError, error}= useServerSideTable<T>({
    endpoint,
    queryKey,
    params: {
      pagination,
      sorting,
      globalFilter
    }
  })

  const data = useMemo(()=> response?.data ?? [], [response]);
  const pageCount = useMemo(()=> response?.meta?.lastPage ?? 0 , [response]);


  const table = useReactTable<T>({
        data,
        columns : columns,
        pageCount,
        state: {
            pagination,
            sorting,
            globalFilter,
        },
        onPaginationChange: setPagination,
        onSortingChange: setSorting,
        onGlobalFilterChange: setGlobalFilter,
        getCoreRowModel: getCoreRowModel(),
        manualPagination: true, 
        manualSorting: true,    
        manualFiltering: true,  
    });

    const UpDown = useMemo<Record<'asc' | 'desc', JSX.Element>>(
        () => ({
            asc: <i className="fa-solid fa-caret-up" />,
            desc: <i className="fa-solid fa-caret-down" />,
        }),
        []
    );

    return {
        table,
        data,
        metadata: response?.meta,
        isLoading,
        isFetching,
        isError,
        error,
        UpDown,
        globalFilter,
        setGlobalFilter,
    };
}
