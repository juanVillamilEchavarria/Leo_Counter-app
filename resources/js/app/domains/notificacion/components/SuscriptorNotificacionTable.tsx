import SimpleTable from "@/app/shared/components/table/simple/SimpleTable"
import { SuscriptorColumns } from './columns/suscriptores.columns'
import type { SuscriptorNotificacion } from '../types/notificacion.types'
import { useMemo } from 'react'

/**
 * Tabla de suscriptores de notificación (CRUD).
 * Delega acciones al padre mediante onSelect.
 * Sigue el patrón de CuentaTable: columnas en useMemo, SimpleTable con data/columns/pagination/pageSize.
 * @param {object} props
 * @param {SuscriptorNotificacion[]} props.data - Lista de suscriptores
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
  data: SuscriptorNotificacion[]
  onSelect: (item: SuscriptorNotificacion, modalType: string) => void
}) {
  const columns = useMemo(() => {
    return SuscriptorColumns({
      onSelect: (item: SuscriptorNotificacion, modalType: string) => {
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
