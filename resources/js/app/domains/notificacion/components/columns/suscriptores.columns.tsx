import { NotificacionToggleActions, NotificacionToggleTypes } from '../../types/notificacion.types'
import ModelToggle from '@/app/shared/components/table/actions/ModelToggle'
import CrudButton from '@/app/shared/components/common/CrudButton'
import type { SimpleTableColumn } from '@/app/shared/types/components'
import type { SuscriptorNotificacion } from '../../types/notificacion.types'

/**
 * Columnas para la tabla de suscriptores de notificación.
 * Incluye toggle de activo con ModelToggle y botones CRUD.
 * Sigue el patrón de cuenta.columns.tsx.
 * @param {object} params
 * @param {Function} params.onSelect - Callback para abrir modales (edit/delete)
 * @returns {SimpleTableColumn<SuscriptorNotificacion>[]}
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.1.0
 */
export const SuscriptorColumns = ({
  onSelect
}: {
  onSelect: (item: SuscriptorNotificacion, modalType: string) => void
}): SimpleTableColumn<SuscriptorNotificacion>[] => [
  { key: 'id', label: 'ID' },
  { key: 'user', label: 'Usuario', render: (row: SuscriptorNotificacion) => row.user?.name ?? row.user_id },
  { key: 'canal', label: 'Canal', render: (row: SuscriptorNotificacion) => row.canal?.nombre ?? row.canal_notificacion_id },
  {
    key: 'activo',
    label: 'Activo',
    className: 'w-40',
    render: (row: SuscriptorNotificacion) => (
      <ModelToggle
        active={row.activo}
        route={NotificacionToggleActions.toggleSuscriptor(row.id, NotificacionToggleTypes.activo)}
      />
    )
  },
  {
    key: 'actions',
    label: '',
    render: (row: SuscriptorNotificacion) => (
      <div className="flex gap-2">
        <CrudButton Crudvariant="Edit" onClick={() => onSelect(row, 'edit')} />
        <CrudButton Crudvariant="Delete" onClick={() => onSelect(row, 'delete')} />
      </div>
    )
  }
]
