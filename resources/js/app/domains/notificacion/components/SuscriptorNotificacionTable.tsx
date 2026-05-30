/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { SuscriptorColumns } from './columns/suscriptores.columns'
import type {  SuscriptorTableData } from '../types/notificacion.types'
import { useMemo } from 'react'

/**
 * Tabla de suscriptores de notificación (CRUD).
 * Delega acciones al padre mediante onSelect.
 * Sigue el patrón de CuentaTable: columnas en useMemo, SimpleTable con data/columns/pagination/pageSize.
 * @param {object} props
 * @param {SuscriptorTableData[]} props.data - Lista de suscriptores
 * @param {Function} props.onSelect - Callback para abrir modales (edit/delete)
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function SuscriptorNotificacionTable({
  pageSize = 10,
  data,
  onSelect
}: {
  pageSize?: number
  data: SuscriptorTableData[]
  onSelect: (item: SuscriptorTableData, modalType: string) => void
}) {
  const columns = useMemo(() => {
    return SuscriptorColumns({
      onSelect: (item: SuscriptorTableData, modalType: string) => {
        onSelect(item, modalType)
      }
    })
  }, [onSelect])

  return (
    <SimpleTable
      data={data}
      columns={columns}
      pagination={true}
      pageSize={pageSize}
    />
  )
}
