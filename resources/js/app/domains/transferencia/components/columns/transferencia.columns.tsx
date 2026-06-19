/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
import MoneyFlow from "@/app/shared/components/common/MoneyFlow";
import { type Transferencia } from "../../types/transferencia.types";
import { dateFormat } from "@/app/shared/helpers";
import { type ColumnDef } from "@tanstack/react-table";

export const TransferenciaColumns = (): ColumnDef<Transferencia>[] => [
    {
        id: 'id',
        header: 'ID',
        accessorKey: 'id'
    },
    {
        id: 'cuentaEnviadora.nombre',
        header: 'Cuenta Origen',
        accessorKey: 'cuentaEnviadora.nombre'
    },
    {
        id: 'cuentaReceptora.nombre',
        header: 'Cuenta Destino',
        accessorKey: 'cuentaReceptora.nombre'
    },
    {
        id: 'monto',
        header: 'Monto',
        accessorKey: 'monto',
        cell: ({ row }) => (
            <MoneyFlow monto={row.original.monto} tipo_movimiento="Ingreso" />
        )
    },
    {
        id: 'fecha',
        header: 'Fecha',
        accessorKey: 'fecha',
        cell: ({ row }) => (
            <span>{dateFormat(row.original.fecha)}</span>
        )
    },
    {
        id: 'descripcion',
        header: 'Descripción',
        accessorKey: 'descripcion'
    }
];
