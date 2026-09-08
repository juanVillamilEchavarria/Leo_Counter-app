/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */
import Modal from '@/app/shared/components/modal/Modal'
import TransitionMotion from '@/app/shared/components/transitions/TransitionMotion'
import { useExportData } from '../hooks/useExportData'
import type { ExportableTableKey, ExportFormat } from '../types/exportacion.types'
import type { ServerSideFilters } from '@/app/shared/types/components/common/table.types'

interface ExportModalProps {
  open: boolean
  onClose: () => void
  table: ExportableTableKey
  totalRecords: number
  filters?: ServerSideFilters
  visibleIds?: string[]
}

export default function ExportModal({
  open,
  onClose,
  table,
  totalRecords,
  filters,
  visibleIds,
}: ExportModalProps) {
  const { form, handleExport, isExporting, reset } = useExportData({
    table,
    totalRecords,
    filters,
    visibleIds,
    onSuccess: onClose,
  })

  const handleClose = () => {
    reset()
    onClose()
  }

  return (
    <Modal open={open} onClose={handleClose} title="Exportar datos" className="gap-4">
      <div className="flex flex-col gap-4 text-sm">
        <p className="text-muted-foreground">
          Exporta los datos de la tabla <strong>{table}</strong> a un archivo descargable.
        </p>

        <div className="flex flex-col gap-2">
          <label className="font-medium">Formato</label>
          <select
            value={form.data.format}
            onChange={(e) => form.setData('format', e.target.value as ExportFormat)}
            className="rounded-lg border px-3 py-2"
          >
            <option value="csv">CSV</option>
            <option value="xlsx">Excel (XLSX)</option>
          </select>
        </div>

        <div className="flex flex-col gap-2">
          <label className="font-medium">Nombre del archivo (opcional)</label>
          <input
            type="text"
            value={form.data.filename}
            onChange={(e) => form.setData('filename', e.target.value)}
            placeholder={`${table}.${form.data.format}`}
            className="rounded-lg border px-3 py-2"
          />
        </div>

        <label className="flex items-center gap-2 cursor-pointer">
          <input
            type="checkbox"
            checked={form.data.only_current_page}
            onChange={(e) => form.setData('only_current_page', e.target.checked)}
          />
          <span>Exportar solo los registros de esta página</span>
        </label>

        <TransitionMotion
          active={!form.data.only_current_page && (!filters?.search && !filters?.sortBy)}
          initial={{ x: 0, y: -100, opacity: 0 }}
          exit={{ x: 0, y: -20, opacity: 0 }}
        >
          <p className="rounded-lg bg-amber-50/20 p-3 text-amber-700 ">
            <i className="fa-solid fa-triangle-exclamation text-lg text-yellow-700"></i> Se exportarán todos los registros. Si la tabla tiene muchos registros, esto puede tardar un tiempo y generar un archivo muy grande <span className="font-black">Maximo exportable : 50.000 registros</span>.
          </p>
        </TransitionMotion>
      </div>

      <div className="flex justify-end gap-3 pt-4">
        <button
          type="button"
          onClick={handleClose}
          className="rounded-lg px-4 py-2 text-sm font-medium border"
          disabled={isExporting}
        >
          Cancelar
        </button>
        <button
          type="button"
          onClick={handleExport}
          disabled={isExporting}
          className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white disabled:opacity-50"
        >
          {isExporting ? 'Exportando...' : 'Exportar'}
        </button>
      </div>
    </Modal>
  )
}