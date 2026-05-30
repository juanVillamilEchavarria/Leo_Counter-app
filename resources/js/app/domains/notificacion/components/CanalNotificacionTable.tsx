/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
import SimpleTable from '@/app/shared/components/table/simple/SimpleTable'
import ModelToggle from '@/app/shared/components/table/actions/ModelToggle'
import { CanalNotificacionActions, NotificacionToggleTypes, type CanalNotificacion } from '../types/notificacion.types'
import type { SimpleTableColumn } from '@/app/shared/types/components'
import { useMemo } from 'react'
import {CanalesColumns} from "@/app/domains/notificacion/components/columns/canales.columns";

/**
 * Tabla de canales de notificación (solo toggle activo).
 * Usa SimpleTable con la API correcta (data, columns, pagination, pageSize).
 * El toggle se resuelve con ModelToggle y la ruta de Ziggy.
 * @param {object} props
 * @param {CanalNotificacion[]} props.data - Lista de canales
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export default function CanalNotificacionTable({
  data,
  pageSize = 10
}: {
  data: CanalNotificacion[]
  pageSize?: number
}) {
  const columns = useMemo((): SimpleTableColumn<CanalNotificacion>[] => CanalesColumns(), [])

  return (
    <SimpleTable
      data={data}
      columns={columns}
      pagination={true}
      pageSize={pageSize}
    />
  )
}
