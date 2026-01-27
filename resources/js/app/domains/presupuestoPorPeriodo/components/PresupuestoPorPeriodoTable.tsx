import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import DeleteModal from "@/app/shared/components/modal/DeleteModal"
import {useSimpleTable} from "@/app/shared/hooks"
import usePresupuestoPorPeriodo from "../hooks/usePresupuestoPorPeriodo"
import { useMemo, useState } from "react"
import { useSimplePagination } from "@/app/shared/hooks"
import { PresupuestoPorPeriodoColumns } from "./columns/presupuestoPorPeriodo.columns"
import { type PresupuestoPorPeriodoTableData } from "../types/presupuestoPorPeriodo.types"
export default function PresupuestoPorPeriodoTable({
    data,
    pageSize = 10
}: {
    data: PresupuestoPorPeriodoTableData[],
    pageSize?: number
}) {
    // const [presupuestoSelected, setPresupuestoSelected] = useState<PresupuestoPorPeriodoTableData | null>(null)
    // const columns = useMemo(() => {
    //     return PresupuestoPorPeriodoColumns({
    //         onDelete: (presupuesto: PresupuestoPorPeriodoTableData) => {
    //             setPresupuestoSelected(presupuesto)
    //         }
    //     })
    // }, [])
    // const { form, handleSubmit } = usePresupuestoPorPeriodo({ method: 'delete', id: presupuestoSelected?.id })
    // const handleDelete = (e: React.FormEvent<HTMLFormElement>) => {
    //     if (!presupuestoSelected) return
    //     handleSubmit(e)
    //     setPresupuestoSelected(null)
    // }
    // const pagination = useSimplePagination(data.length, pageSize)
    // const start = pagination.page * pageSize
    // const end = start + pageSize
    // const paginatedData = data.slice(start, end)

    const config=useSimpleTable({
        data,
        pageSize,
        tableColumns: PresupuestoPorPeriodoColumns,
        formModelHook: usePresupuestoPorPeriodo
    })
    const {
        data: paginatedData,
        columns,
        pagination,
        handleDelete,
        itemSelected,
        setItemSelected
    } = config

    return (
        <>
            <SimpleTable
                data={paginatedData}
                columns={columns}
                pagination={true}
                controller={pagination}
            />
            <DeleteModal
                open={itemSelected !== null}
                onClose={() => setItemSelected(null)}
                onSubmit={handleDelete}
                spanTitle={'Eliminar'}
                title={' Presupuesto'}
                paragraph={`¿Esta seguro de eliminar el Presupuesto de: ${itemSelected?.categoria} (${itemSelected?.descripcion || 'Sin descripción'}) ?`}
            >
                <small>Los presupuestos eliminados estaran en la configuración del sistema</small>
            </DeleteModal>
        </>
    )
}
