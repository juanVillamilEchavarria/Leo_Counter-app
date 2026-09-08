/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

import type { ServerSideFilters } from "@/app/shared/types/components/common/table.types"
import { route } from "ziggy-js"

export type ExportFormat = 'csv' | 'xlsx'

export type ExportableTableKey =
  | 'movimientos'
  | 'auditorias'
  | 'presupuestos'
  | 'cuentas'
  | 'categorias'
  | 'propietarios'
  | 'movimientos_fijos'
  | 'movimientos_pendientes'
  | 'transferencias'



export interface ExportParams {
  table: ExportableTableKey
  format: ExportFormat
  filename?: string
  only_current_page: boolean
  filters?: ServerSideFilters
  visibleIds?: string[]
}

export interface ExportFormData {
  format: ExportFormat
  filename: string
  only_current_page: boolean
}

export interface ExportacionTableData {
  id: string
  user_name: string
  user_email?: string
  table: string
  format: 'csv' | 'xlsx'
  records_count: number
  filename: string
  filters?: Record<string, any> | null
  created_at: string
}

export const ExportacionRoutes = {
  index: () => route('exportaciones.index'),
}

export const ExportacionApiActions = {
  paginatedData: '/exportaciones',
}