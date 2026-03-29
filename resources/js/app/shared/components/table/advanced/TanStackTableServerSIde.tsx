import { flexRender, type ColumnDef } from '@tanstack/react-table';
import Search from '../actions/Search';
import TablePagination from '../pagination/TablePagination';
import TableEntries from '../pagination/TableEntries';
import { useTanStackPagination } from '@/app/shared/hooks';
import useServerSideTanStackTable from '@/app/shared/hooks/table/advanced/useServerSideTanStackTable';
import {useEntries} from '@/app/shared/hooks';

interface TanStackTableServerSideProps<T> {
    columns: ColumnDef<T, any>[];
    endpoint: string;
    queryKey: string[];
    pageSize?: number;
}

export default function TanStackTableServerSide<T extends Record<string, any>>({
    columns,
    endpoint,
    queryKey,
    pageSize = 10,
}: TanStackTableServerSideProps<T>) {
    
    const {entries, setEntries} = useEntries({value:pageSize});

    const {
        table,
        isLoading,
        isFetching,
        isError,
        error,
        UpDown,
        globalFilter,
        setGlobalFilter,
    } = useServerSideTanStackTable({
        columns,
        endpoint,
        queryKey,
        initialPageSize: entries,
    });

    const controller = useTanStackPagination(table);

    if (isError) {
        return (
            <div className="p-4 bg-red-50 border border-red-200 rounded">
                <p className="text-red-600">Error al cargar datos: {error?.message}</p>
            </div>
        );
    }

    return (
        <div>
            <div className="flex w-full justify-start gap-3">
                  <Search value={globalFilter} setValue={setGlobalFilter} />
            {/* Indicador de carga */}
            {isFetching && (
                <div className="flex justify-center items-center p-4">
                    <i className="fas fa-spinner fa-spin text-blue-500 mr-2"></i>
                    <span className="text-muted-foreground">Cargando...</span>
                </div>
            )}

            </div>
          

            {/* Tabla */}
            <div className="table-container">
                <table className="table-general">
                    <thead className="table-thead">
                        {table.getHeaderGroups().map((headerGroup) => (
                            <tr key={headerGroup.id}>
                                {headerGroup.headers.map((header) => {
                                    const isSorted = header.column.getIsSorted();
                                    return (
                                        <th
                                            key={header.id}
                                            onClick={header.column.getToggleSortingHandler()}
                                        >
                                            <div className="flex justify-start text-left gap-1 cursor-pointer">
                                                {flexRender(
                                                    header.column.columnDef.header,
                                                    header.getContext()
                                                )}
                                                {isSorted !== false && UpDown[isSorted]}
                                            </div>
                                        </th>
                                    );
                                })}
                            </tr>
                        ))}
                    </thead>
                    <tbody className="table-tbody">
                        {isLoading ? (
                            <tr>
                                {/* Si esta cargando la data, muestra el indicador */}
                                <td colSpan={columns.length} className="text-center p-8">
                                    <i className="fas fa-spinner fa-spin text-2xl"></i>
                                </td>
                            </tr>
                        ) : table.getRowModel().rows.length > 0 ? (
                            table.getRowModel().rows.map((row) => (
                                <tr key={row.id} className='text-foreground'>
                                    {row.getVisibleCells().map((cell) => (
                                        <td key={cell.id}>
                                            {cell.getValue() !== null ? (
                                                flexRender(
                                                    cell.column.columnDef.cell,
                                                    cell.getContext()
                                                )
                                            ) : (
                                                <span className="text-muted-foreground">CAMPO VACÍO</span>
                                            )}
                                        </td>
                                    ))}
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td
                                    colSpan={columns.length}
                                    className="text-muted-foreground text-xl text-center"
                                >
                                    No hay registros
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>

            {/* Pagination */}
            <div className="w-full flex justify-between mt-5">
                <TablePagination controller={controller} />
                <TableEntries entries={entries} setEntries={(value) => {
                    setEntries(value);
                    table.setPageSize(value);  
                    table.setPageIndex(0);   
                }} />
            </div>
        </div>
    );
}