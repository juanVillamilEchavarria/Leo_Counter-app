/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import { useState } from 'react'
import ExportModal from './ExportModal'
import type { ExportableTableKey } from '../types/exportacion.types'
import {type  ServerSideFilters } from '@/app/shared/types/components/common/table.types'

interface ExportButtonProps {
  table: ExportableTableKey
  totalRecords: number
  filters?: ServerSideFilters
  visibleIds?: string[]
  disabled?: boolean
}

export default function ExportButton({
  table,
  totalRecords,
  filters,
  visibleIds,
  disabled = false,
}: ExportButtonProps) {
  const [open, setOpen] = useState(false)

  return (
    <>
      <button
        type="button"
        onClick={() => setOpen(true)}
        disabled={disabled}
        className=" rounded-lg px-3 py-2 text-lg disabled:opacity-50 text-foreground hover:bg-foreground/10 cursor-pointer transition-colors"
      >
        <i className="fa-solid fa-download" />
      </button>

      <ExportModal
        open={open}
        onClose={() => setOpen(false)}
        table={table}
        totalRecords={totalRecords}
        filters={filters}
        visibleIds={visibleIds}
      />
    </>
  )
}